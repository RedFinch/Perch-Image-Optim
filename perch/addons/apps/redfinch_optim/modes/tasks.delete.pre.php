<?php

$Tasks = new RedFinchOptim_Tasks($API);

if (isset($_GET['id']) && $_GET['id'] != '') {
    $task = $Tasks->find($_GET['id'], true);
} else {
    PerchUtil::redirect($API->app_path());
}

$Form->set_name('delete');

if ($Form->submitted()) {
    if (is_object($task)) {

        $task->delete();

        if ($Form->submitted_via_ajax) {
            echo $API->app_path() . '/';
            exit;
        } else {
            PerchUtil::redirect($API->app_path() . '/');
        }
    } else {
        $Alert->set('error', $Lang->get('Sorry, the task could not be deleted.'));
    }
}

$details = $task->to_array();
