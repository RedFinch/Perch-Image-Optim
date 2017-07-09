<?php

// Title panel
echo $HTML->title_panel([
    'heading' => $Lang->get('Run Task')
], $CurrentUser);

// Notifications
if ($task->hasSucceeded()) {
    echo $HTML->success_message('This task has executed successfully - you may review the output below.');
}

if ($task->hasFailed()) {
    echo $HTML->failure_message('This task could not complete - please review the logs below.');
}

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'type'  => 'breadcrumb',
    'links' => [
        [
            'title' => 'Tasks',
            'link'  => $API->app_nav()
        ],
        [
            'title' => 'Result'
        ]
    ],
    'active' => true
]);

$Smartbar->add_item([
    'title'    => 'Re-run',
    'link'     => $API->app_nav() . '/run/?t=' . $taskID . '&force=true',
    'icon'     => 'core/o-undo',
    'position' => 'end'
]);

echo $Smartbar->render();

// Output
echo PerchUI::render_progress_list($HTML, $Logs->taskProgress($taskID));
