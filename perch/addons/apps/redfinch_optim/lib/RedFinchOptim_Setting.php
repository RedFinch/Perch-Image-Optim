<?php

/**
 * Class RedFinchOptim_Setting
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Setting extends PerchAPI_Base
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
     * Shorthand for settingValue();
     *
     * @return string
     */
    public function value()
    {
        return $this->settingValue();
    }
}
