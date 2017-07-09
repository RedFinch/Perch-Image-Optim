<?php

echo $Form->hint('Enable or disable lossless PNG file optimisation.');
echo $Form->checkbox_field('optipng_enabled', 'Enabled', 1, $OptimSettings->get('optipng_enabled', 1)->value());

// Appears to be failing - review later.
//echo $Form->hint('Removes all additional data from the file.');
//echo $Form->checkbox_field('optipng_strip', 'Strip Metadata', 1, $OptimSettings->get('optipng_strip', 1)->value());

$level_opts = [];
for ($i = 0; $i <= 7; $i++) {
    $level_opts[] = [
        'label' => $i,
        'value' => $i
    ];
}

echo $Form->hint('Higher values will produce smaller files but will take longer to complete.');
echo $Form->select_field('optipng_level', 'Level', $level_opts, $OptimSettings->get('optipng_level', 2)->value());