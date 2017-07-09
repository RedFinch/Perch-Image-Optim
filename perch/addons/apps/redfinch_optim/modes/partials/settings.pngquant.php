<?php

echo $Form->hint('Enable or disable lossy PNG file optimisation.');
echo $Form->checkbox_field('pngquant_enabled', 'Enabled', 1, $OptimSettings->get('pngquant_enabled', 1)->value());

$quality_opts = [];
for ($i = 0; $i < 100; $i += 10) {
    $quality_opts[] = [
        'label' => $i . '-' . ($i + 10),
        'value' => $i . '-' . ($i + 10),
    ];
}

echo $Form->hint('Set the compression quality range.');
echo $Form->select_field('pngquant_quality', 'Quality', $quality_opts, $OptimSettings->get('pngquant_quality', '90-100')->value());

$speed_opts = [
    ['label' => 'Best Result', 'value' => 1],
    ['label' => 'Default', 'value' => 3],
    ['label' => 'Fastest', 'value' => 10]
];

echo $Form->hint('Choose between maximum compression or fastest execution.');
echo $Form->select_field('pngquant_speed', 'Speed', $speed_opts, $OptimSettings->get('pngquant_speed', 3)->value());
