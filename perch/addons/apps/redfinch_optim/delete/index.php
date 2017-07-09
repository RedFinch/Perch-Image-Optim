<?php

include(__DIR__ . '/../../../../core/inc/api.php');

// Permissions
if(!($CurrentUser->logged_in() && $CurrentUser->has_priv('redfinch_optim.delete'))) {
    PerchUtil::redirect(PERCH_LOGINPATH);
}

// Perch API
$API = new PerchAPI(1.0, 'redfinch_optim');

// APIs
$Lang = $API->get('Lang');
$HTML = $API->get('HTML');
$Form = $API->get('Form');
$Settings = $API->get('Settings');

// Page settings
$Perch->page_title = $Lang->get('Delete Task');

// Page Initialising
include('../modes/_subnav.php');
include('../modes/tasks.delete.pre.php');

// Perch Frame
include(PERCH_CORE . '/inc/top.php');

// Page
include('../modes/tasks.delete.post.php');

// Perch Frame
include(PERCH_CORE . '/inc/btm.php');
