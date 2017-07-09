<?php

/**
 * Class RedFinchOptim_Log
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Log extends PerchAPI_Base
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
}