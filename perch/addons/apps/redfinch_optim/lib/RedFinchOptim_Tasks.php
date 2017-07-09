<?php

/**
 * Class RedFinchOptim_Tasks
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Tasks extends PerchAPI_Factory
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
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'taskID';

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
    protected $singular_classname = 'RedFinchOptim_Task';

    /**
     * Task status filter value
     *
     * @var null|string
     */
    protected $statusFilter;

    /**
     * Return tasks that are waiting to be processed
     *
     * @return array|bool|SplFixedArray
     */
    public function getQueue()
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE taskStatus = "WAITING" ORDER BY taskID';

        $rows = $this->db->get_rows($sql);

        return $this->return_instances($rows);
    }

    /**
     * Return completed tasks that are older than the cutoff point
     *
     * @param int $seconds
     *
     * @return mixed
     */
    public function getForCleanup($seconds)
    {
        $cutoff = time() - $seconds;

        $sql = 'SELECT taskID FROM ' . $this->table . ' WHERE taskStatus = "OK" AND taskEnd <= ' . $this->db->pdb($cutoff);

        $rows = $this->db->get_rows($sql);

        return $this->return_instances($rows);
    }

    /**
     * Returns unique array of in-use statuses
     *
     * @return array
     */
    public function getStatuses()
    {
        $sql = 'SELECT DISTINCT taskStatus FROM ' . $this->table;

        $rows = $this->db->get_rows($sql);

        return array_map(function ($item) {
            return $item['taskStatus'];
        }, $rows);
    }

    /**
     * Set status filter value
     *
     * @param string $status
     *
     * @return $this
     */
    public function filterByStatus($status)
    {
        $this->statusFilter = $status;

        return $this;
    }

    /**
     * Add constraints to any system query
     *
     * @return string
     */
    protected function standard_restrictions()
    {
        $sql = '';

        if ($this->statusFilter) {
            $sql .= ' AND `taskStatus` = ' . $this->db->pdb($this->statusFilter);
        }

        return $sql;
    }
}