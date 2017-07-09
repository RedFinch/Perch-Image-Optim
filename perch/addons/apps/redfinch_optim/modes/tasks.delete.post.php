<?php

// Title
echo $HTML->title_panel([
    'heading' => $Lang->get('Delete Task')
], $CurrentUser);

echo $Form->form_start();
    echo $HTML->warning_message('Are you sure you wish to delete the task ‘%s’', $details['taskFile']);
    echo $Form->hidden('taskID', $details['taskID']);
    echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());
echo $Form->form_end();