<?php

/**
 * Class RedFinchOptim_Logs
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Logs extends PerchAPI_Factory
{
    /**
     * Logs table
     *
     * @var string
     */
    protected $table = 'redfinch_optim_logs';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'logID';

    /**
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'logCreated';

    /**
     * Sort direction
     *
     * @var string
     */
    protected $default_sort_direction = 'DESC';

    /**
     * Factory singular class
     *
     * @var string
     */
    protected $singular_classname = 'RedFinchOptim_Log';

    /**
     * Create multiple rows from an array
     *
     * @param array $data
     */
    public function createBatch(array $data)
    {
        foreach ($data as $insert) {
            $this->create($insert);
        }
    }

    /**
     * Insert row into database
     *
     * @param $data
     *
     * @return bool
     */
    public function create($data)
    {
        $data['logCreated'] = date('Y-m-d H:i:s');

        return parent::create($data);
    }

    /**
     * Remove all logs for task
     *
     * @param int $taskID
     *
     * @return bool
     */
    public function clearForTask($taskID)
    {
        return $this->db->delete($this->table, 'taskID', $taskID);
    }

    /**
     * Formats rows for use with progress lists in the Perch UI.
     *
     * @param int $taskID
     *
     * @return array
     */
    public function taskProgress($taskID) : array
    {
        $rows = $this->db->get_rows('SELECT * FROM ' . $this->table . ' WHERE taskID = ' . $this->db->pdb($taskID));

        return array_map(function($row) {
            if($row['logLevel'] === 'error') $row['logLevel'] = 'failure';

            return [
                'status'  => $row['logLevel'],
                'message' => $row['logMessage']
            ];
        }, $rows);
    }
}