<?php

// Register app
$this->register_app('redfinch_optim', 'Optimiser', 5, 'Compresses created images using installed system libraries', '1.0');
$this->require_version('redfinch_optim', '3.0');

// Settings
$this->add_setting('redfinch_optim_gc', 'Task cleanup', 'select', 604800, [
    ['label' => '1 Day', 'value' => 1440],
    ['label' => '7 Days', 'value' => 604800],
    ['label' => '14 Days', 'value' => 1209600],
    ['label' => '30 Days', 'value' => 18144000],
    ['label' => 'Never', 'value' => -1]
], 'Completed tasks will be cleared after the selected period.');

$this->add_setting('redfinch_optim_timeout', 'Max execution time', 'text', 30, false, 'Limit the number of seconds each optimisation task can run for.');

// Autoloader
require __DIR__ . '/autoloader.php';

// Listeners
require __DIR__ . '/listeners.php';
