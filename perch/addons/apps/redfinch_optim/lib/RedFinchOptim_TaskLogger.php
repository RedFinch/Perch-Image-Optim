<?php

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Class RedFinchOptim_TaskLogger
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_TaskLogger extends AbstractLogger
{
    protected $logs = [];

    public function log($level, $message, array $context = [])
    {
        $this->logs[] = [
            'level'   => $level,
            'message' => $this->interpolate($message, $context)
        ];

        PerchUtil::debug($this->interpolate($message, $context), $level);
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function hasFailed()
    {
        return count(array_filter($this->logs, function ($item) {
                return $item['level'] === LogLevel::ERROR;
            })) > 0;
    }

    public function hasSkipped()
    {
        return count(array_filter($this->logs, function ($item) {
                return (strpos($item['message'], 'skipped') !== false);
            })) > 0;
    }

    public function hasSucceeded()
    {
        return !$this->hasFailed() && !$this->hasSkipped();
    }

    private function interpolate($message, array $context = [])
    {
        $replace = [];

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}