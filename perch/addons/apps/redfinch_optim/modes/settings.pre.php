<?php

// Settings
$OptimSettings = RedFinchOptim_Settings::fetch();

// Form Handling
if ($Form->submitted()) {
    $postvars = [
        'gifsicle_enabled',
        'gifsicle_level',
        'jpegoptim_enabled',
        'jpegoptim_progressive',
        'jpegoptim_strip',
        'jpegoptim_quality',
        'optipng_enabled',
        'optipng_strip',
        'optipng_level',
        'pngquant_enabled',
        'pngquant_quality',
        'pngquant_speed',
        'svgo_enabled',
        'svgo_plugins'
    ];

    $booleans = [
        'gifsicle_enabled',
        'jpegoptim_enabled',
        'jpegoptim_progressive',
        'jpegoptim_strip',
        'optipng_enabled',
        'optipng_strip',
        'pngquant_enabled',
        'svgo_enabled'
    ];

    $arrays = [
        'svgo_plugins'
    ];

    $data = $Form->receive($postvars);

    // Handle checkbox values
    foreach ($booleans as $bool) {
        if (!isset($data[$bool])) {
            $data[$bool] = 0;
        }
    }

    // Handle array values
    foreach ($arrays as $array) {
        $data[$array] = json_encode($data[$array]);
    }

    // Save results
    foreach ($data as $key => $value) {
        $OptimSettings->set($key, $value);
    }

    $Alert->set('success', $Lang->get('Image settings have been updated.'));

    $OptimSettings->flushCache();
}
