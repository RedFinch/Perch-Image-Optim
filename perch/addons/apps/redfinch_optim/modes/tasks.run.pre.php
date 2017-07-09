<?php

// Fetch Item
if (isset($_GET['t']) && $_GET['t'] != '') {
    $taskID = (int) $_GET['t'];
} else {
    PerchUtil::redirect($API->app_path() . '/');
}

// Data
$Tasks = new RedFinchOptim_Tasks($API);
$Logs = new RedFinchOptim_Logs($API);

// Item

/**
 * @var RedFinchOptim_Task $task
 */
$task = $Tasks->find($taskID);

// Run
if(!$task->hasExecuted()) {
    $task->execute();
}

// Force
if(isset($_GET['force'])) {
    $task->execute();
}
