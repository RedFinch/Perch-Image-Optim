<?php

// Title panel
echo $HTML->title_panel([
    'heading' => $Lang->get('Settings')
], $CurrentUser);

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title'  => 'Settings',
    'link'   => $API->app_nav() . '/settings/',
    'icon'   => 'core/gear'
]);

echo $Smartbar->render();

// Form
echo $Form->form_start();

echo $HTML->heading2('Gifsicle');
include __DIR__ . '/partials/settings.gifsicle.php';

echo $HTML->heading2('JpegOptim');
include __DIR__ . '/partials/settings.jpegoptim.php';

echo $HTML->heading2('Optipng');
include __DIR__ . '/partials/settings.optipng.php';

echo $HTML->heading2('Pngquant');
include __DIR__ . '/partials/settings.pngquant.php';

echo $HTML->heading2('SVGO');
include __DIR__ . '/partials/settings.svgo.php';

echo $Form->submit_field('btnSubmit', 'Save changes', $API->app_path());

echo $Form->form_end();
