<?php

/**
 * Class RedFinchOptim_Task
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Task extends PerchAPI_Base
{
    /**
     * Tasks table
     *
     * @var string
     */
    protected $table = 'redfinch_optim_tasks';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'taskID';


    /**
     * Runs an optimisation tasks and saves the output to the logger
     *
     * @return bool
     */
    public function execute()
    {
        $data = [];

        $data['taskStart'] = time();

        $logger = new RedFinchOptim_TaskLogger();
        $log = new RedFinchOptim_Logs();

        RedFinchOptim_Image::onTaskExecute($this->taskPath(), $logger);

        if ($logger->hasFailed()) {
            $data['taskStatus'] = 'FAILED';
        }

        if ($logger->hasSucceeded() || $logger->hasSkipped()) {
            $data['taskStatus'] = 'OK';
            $data['taskPostSize'] = filesize($this->taskPath());
        }

        $data['taskEnd'] = time();

        $log->clearForTask($this->id());
        $log->createBatch(array_map(function ($log) {
            return [
                'taskID'     => $this->id(),
                'logLevel'   => $log['level'],
                'logMessage' => $log['message']
            ];
        }, $logger->getLogs()));

        $this->update($data);

        return ($logger->hasSucceeded() || $logger->hasSkipped());
    }

    /**
     * General 'has the task run' boolean
     *
     * @return bool
     */
    public function hasExecuted()
    {
        return $this->taskStatus() !== 'WAITING';
    }

    /**
     * Has the task completed successfully
     *
     * @return bool
     */
    public function hasSucceeded()
    {
        return $this->taskStatus() === 'OK';
    }

    /**
     * Has the task completed encountering an error
     *
     * @return bool
     */
    public function hasFailed()
    {
        return $this->taskStatus() === 'FAILED';
    }

    public function delete()
    {
        (new RedFinchOptim_Logs())->clearForTask($this->id());

        parent::delete();
    }
}
