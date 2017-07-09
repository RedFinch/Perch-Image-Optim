<?php

require __DIR__ . '/lib/vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'RedFinchOptim') === 0) {
        include(PERCH_PATH . '/addons/apps/redfinch_optim/lib/' . $class_name . '.php');

        return true;
    }

    return false;
});

