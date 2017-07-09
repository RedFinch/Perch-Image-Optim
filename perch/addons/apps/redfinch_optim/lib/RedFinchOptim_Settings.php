<?php

/**
 * Class RedFinchOptim_Settings
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Settings extends PerchAPI_Factory
{
    /**
     * Tasks table
     *
     * @var string
     */
    protected $table = 'redfinch_optim_settings';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'settingKey';

    /**
     * Factory singular class
     *
     * @var string
     */
    protected $singular_classname = 'RedFinchOptim_Setting';

    /**
     * Singleton instance
     *
     * @var RedFinchOptim_Settings
     */
    static private $instance;

    /**
     * Fetch singleton instance
     *
     * @return RedFinchOptim_Settings
     */
    public static function fetch()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;

            self::$instance = new $c;
        }

        return self::$instance;
    }

    /**
     * Create / update a setting value
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
        $this->db->delete($this->table, 'settingKey', $key);

        return $this->create([
            'settingKey'   => $key,
            'settingValue' => $value
        ]);
    }

    /**
     * Return a setting instance
     *
     * @param string $settingKey
     * @param null   $default
     *
     * @return RedFinchOptim_Setting
     */
    public function get($settingKey, $default = null)
    {
        if ($this->cache === false) {
            $rows = $this->db->get_rows('SELECT * FROM ' . $this->table);

            $this->cache = [];

            if (PerchUtil::count($rows) > 0) {
                foreach ($rows as $row) {
                    $this->cache[$row['settingKey']] = $row;
                }
            }
        }

        if (isset($this->cache[$settingKey])) {
            return $this->return_instance($this->cache[$settingKey]);
        }

        return $this->return_instance(['settingKey' => $settingKey, 'settingValue' => $default]);
    }

    /**
     * Force new values to be loaded from database
     */
    public function flushCache()
    {
        $this->cache = false;
    }
}
