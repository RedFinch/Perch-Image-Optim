<?php

// Title panel
echo $HTML->title_panel([
    'heading' => $Lang->get('Tasks')
], $CurrentUser);

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => $filter === 'all',
    'title'  => 'All',
    'link'   => $API->app_nav()
]);

$Smartbar->add_item([
    'id'      => 'status',
    'title'   => 'Status',
    'icon'    => 'core/o-heart-rate',
    'active'  => PerchRequest::get('status'),
    'type'    => 'filter',
    'arg'     => 'status',
    'options' => array_map(function ($item) {
        return ['value' => $item, 'title' => $item];
    }, $Tasks->getStatuses()),
    'actions' => []
]);

echo $Smartbar->render();

// Listing
$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

$Listing->add_col([
    'title' => 'Status',
    'value' => 'taskStatus',
    'icon'      => function($task) {
        switch($task->taskStatus()) {
            case 'OK':
                return PerchUI::icon('core/circle-check', 16, null, 'icon-status-success');
                break;

            case 'WAITING':
                return PerchUI::icon('core/clock', 16, null, 'icon-status-info');
                break;

            case 'FAILED':
                return PerchUI::icon('core/circle-delete', 16, null, 'icon-status-alert');
                break;

            default:
                return PerchUI::icon('core/info-alt', 16, null, 'icon-status-info');
                break;
        }
    }
]);

$Listing->add_col([
    'title' => 'File',
    'value' => 'taskFile'
]);

$Listing->add_col([
    'title' => 'Original',
    'value' => function($task) {
        return PerchUtil::format_file_size($task->taskPreSize());
    }
]);

$Listing->add_col([
    'title' => 'Size',
    'value' => function($task) {
        return PerchUtil::format_file_size($task->taskPostSize());
    }
]);

$Listing->add_col([
    'title' => 'Savings',
    'value' => function ($task) {
        if ($task->taskPostSize() > 0) {
            return round(($task->taskPreSize() - $task->taskPostSize()) / $task->taskPreSize() * 100, 2) . '%';
        }

        return 0;
    }
]);

$Listing->add_col([
    'title' => 'Duration',
    'value' => function ($task) {
        return $task->taskEnd() - $task->taskStart() . 's';
    }
]);

$Listing->add_misc_action([
    'priv'  => 'redfinch_optim.run_task',
    'title' => 'Run Task',
    'class' => 'action',
    'path'  => function ($task) use ($API) {
        return PERCH_LOGINPATH . $API->app_nav() . '/run/?t=' . $task->id();
    }
]);

$Listing->add_delete_action([
    'priv'   => 'redfinch_optim.delete',
    'inline' => true,
    'path'   => 'delete',
]);

echo $Listing->render($tasks);
