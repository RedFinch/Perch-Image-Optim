<?php

echo $Form->hint('Enable or disable GIF file optimisation.');
echo $Form->checkbox_field('gifsicle_enabled', 'Enabled', 1, $OptimSettings->get('gifsicle_enabled', 1)->value());

$level_opts = [];
for ($i = 1; $i <= 3; $i++) {
    $level_opts[] = [
        'label' => $i,
        'value' => $i
    ];
}

echo $Form->hint('Higher values will produce smaller files but will take longer to complete.');
echo $Form->select_field('gifsicle_level', 'Level', $level_opts, $OptimSettings->get('gifsicle_level', 3)->value());