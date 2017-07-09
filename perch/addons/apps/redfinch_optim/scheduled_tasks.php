<?php require __DIR__ . '/autoloader.php';

PerchScheduledTasks::register_task('redfinch_optim', 'redfinch_optim_optimise_task', 1440, 'redfinch_optim_execute_task_queue');

function redfinch_optim_execute_task_queue($last_run_date)
{
    $API = new PerchAPI(1.0, 'redfinch_optim');

    $Tasks = new RedFinchOptim_Tasks($API);
    $queue = $Tasks->getQueue();

    $total = PerchUtil::count($queue);
    $successes = 0;
    $errors = 0;

    if(PerchUtil::count($queue)) {
        foreach ($queue as $task) {
            $result = $task->execute();

            if ($result) {
                $successes++;
            } else {
                $errors++;
            }
        }
    }

    if ($successes === $total) {
        return [
            'result'  => 'OK',
            'message' => sprintf('%s images have been optimised.', $total)
        ];
    }

    if ($errors === $total) {
        return [
            'result'  => 'FAILED',
            'message' => 'Unable to optimise images. Please check server logs.'
        ];
    }

    return [
        'result'  => 'WARNING',
        'message' => sprintf('%s of %s images did not optimise. Please check task logs.', $errors, $total)
    ];
}

$Settings = PerchSettings::fetch();

if($Settings->get('redfinch_optim_gc')->val() !== '-1') {
    PerchScheduledTasks::register_task('redfinch_optim', 'redfinch_optim_clear_tasks', 1440, 'redfinch_optim_clear_completed_tasks');

    function redfinch_optim_clear_completed_tasks($last_run_date)
    {
        $API = new PerchAPI(1.0, 'redfinch_optim');

        $Settings = $API->get('Settings');
        $Tasks = new RedFinchOptim_Tasks($API);

        $tasks = $Tasks->getForCleanup($Settings->get('redfinch_optim_gc')->val());

        if (PerchUtil::count($tasks)) {
            foreach ($tasks as $task) {
                $task->delete();
            }

            return [
                'result'  => 'OK',
                'message' => sprintf('%s Completed tasks have been cleared.', PerchUtil::count($tasks))
            ];
        }

        return [
            'result'  => 'OK',
            'message' => 'No tasks to clear.'
        ];
    }
}