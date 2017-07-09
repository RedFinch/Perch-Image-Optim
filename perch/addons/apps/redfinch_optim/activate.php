<?php

if (!defined('PERCH_DB_PREFIX')) {
    exit;
}

// Database
$sql = file_get_contents(__DIR__ . '/sql/schema.sql');
$sql .= file_get_contents(__DIR__ . '/sql/settings.sql');

$sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);

// Install
$statements = explode(';', $sql);
foreach ($statements as $statement) {
    $statement = trim($statement);
    if ($statement != '') {
        $this->db->execute($statement);
    }
}

// Permissions
$API = new PerchAPI(1.0, 'redfinch_optim');
$UserPrivileges = $API->get('UserPrivileges');
$UserPrivileges->create_privilege('redfinch_optim', 'View tasks');
$UserPrivileges->create_privilege('redfinch_optim.run_task', 'Run tasks');
$UserPrivileges->create_privilege('redfinch_optim.delete', 'Delete tasks');
$UserPrivileges->create_privilege('redfinch_optim.config', 'Change settings');

// Settings
$Settings = $API->get('Settings');
$Settings->set('redfinch_optim_gc', 604800);
$Settings->set('redfinch_optim_timeout', 30);

// Installation check
$sql = 'SHOW TABLES LIKE "' . $this->table . '"';
$result = $this->db->get_value($sql);

return $result;
