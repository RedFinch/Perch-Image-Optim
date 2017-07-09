<?php

echo $Form->hint('Enable or disable JPEG file optimisation.');
echo $Form->checkbox_field('jpegoptim_enabled', 'Enabled', 1, $OptimSettings->get('jpegoptim_enabled', 1)->value());

echo $Form->hint('Converts all optimised files to be progressive.');
echo $Form->checkbox_field('jpegoptim_progressive', 'Progressive', 1, $OptimSettings->get('jpegoptim_progressive', 1)->value());

echo $Form->hint('Removes all additional data (such as EXIF) from the file.');
echo $Form->checkbox_field('jpegoptim_strip', 'Strip Metadata', 1, $OptimSettings->get('jpegoptim_strip', 1)->value());

$quality_opts = [];
for ($i = 0; $i <= 100; $i += 10) {
    $quality_opts[] = [
        'label' => $i,
        'value' => $i
    ];
}

echo $Form->hint('Set the maximum compression quality.');
echo $Form->select_field('jpegoptim_quality', 'Quality', $quality_opts, $OptimSettings->get('jpegoptim_quality', 80)->value());