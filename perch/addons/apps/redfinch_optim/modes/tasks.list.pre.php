<?php

$Paging = $API->get('Paging');
$Paging->set_per_page('20');

// Data
$Tasks = new RedFinchOptim_Tasks($API);

// Filters
$filter = 'all';

if (isset($_GET['status']) && $_GET['status'] != '') {
    $filter = 'status';
    $Tasks->filterByStatus($_GET['status']);
}

if (isset($_GET['show-filter']) && $_GET['show-filter']!='') {
    $filter = $_GET['show-filter'];
}

// Fetch
$tasks = $Tasks->all($Paging);

// Install app
if ($tasks === false) {
    $Tasks->attempt_install();
}
