<?php

echo $Form->hint('Enable or disable SVG file optimisation.');
echo $Form->checkbox_field('svgo_enabled', 'Enabled', 1, $OptimSettings->get('svgo_enabled', 1)->value());

$plugin_opts = [
    ['label' => 'cleanupAttrs', 'value' => 'cleanupAttrs'],
    ['label' => 'removeDoctype', 'value' => 'removeDoctype'],
    ['label' => 'removeXMLProcInst', 'value' => 'removeXMLProcInst'],
    ['label' => 'removeComments', 'value' => 'removeComments'],
    ['label' => 'removeMetadata', 'value' => 'removeMetadata'],
    ['label' => 'removeTitle', 'value' => 'removeTitle'],
    ['label' => 'removeDesc', 'value' => 'removeDesc'],
    ['label' => 'removeUselessDefs', 'value' => 'removeUselessDefs'],
    ['label' => 'removeXMLNS', 'value' => 'removeXMLNS'],
    ['label' => 'removeEditorsNSData', 'value' => 'removeEditorsNSData'],
    ['label' => 'removeEmptyAttrs', 'value' => 'removeEmptyAttrs'],
    ['label' => 'removeHiddenElems', 'value' => 'removeHiddenElems'],
    ['label' => 'removeEmptyText', 'value' => 'removeEmptyText'],
    ['label' => 'removeEmptyContainers', 'value' => 'removeEmptyContainers'],
    ['label' => 'removeViewBox', 'value' => 'removeViewBox'],
    ['label' => 'cleanupEnableBackground', 'value' => 'cleanupEnableBackground'],
    ['label' => 'minifyStyles', 'value' => 'minifyStyles'],
    ['label' => 'convertStyleToAttrs', 'value' => 'convertStyleToAttrs'],
    ['label' => 'convertColors', 'value' => 'convertColors'],
    ['label' => 'convertPathData', 'value' => 'convertPathData'],
    ['label' => 'convertTransform', 'value' => 'convertTransform'],
    ['label' => 'removeUnknownsAndDefaults', 'value' => 'removeUnknownsAndDefaults'],
    ['label' => 'removeNonInheritableGroupAttrs', 'value' => 'removeNonInheritableGroupAttrs'],
    ['label' => 'removeUselessStrokeAndFill', 'value' => 'removeUselessStrokeAndFill'],
    ['label' => 'removeUnusedNS', 'value' => 'removeUnusedNS'],
    ['label' => 'cleanupIDs', 'value' => 'cleanupIDs'],
    ['label' => 'cleanupNumericValues', 'value' => 'cleanupNumericValues'],
    ['label' => 'cleanupListOfValues', 'value' => 'cleanupListOfValues'],
    ['label' => 'moveElemsAttrsToGroup', 'value' => 'moveElemsAttrsToGroup'],
    ['label' => 'moveGroupAttrsToElems', 'value' => 'moveGroupAttrsToElems'],
    ['label' => 'collapseGroups', 'value' => 'collapseGroups'],
    ['label' => 'removeRasterImages', 'value' => 'removeRasterImages'],
    ['label' => 'mergePaths', 'value' => 'mergePaths'],
    ['label' => 'convertShapeToPath', 'value' => 'convertShapeToPath'],
    ['label' => 'sortAttrs', 'value' => 'sortAttrs'],
    ['label' => 'transformsWithOnePath', 'value' => 'transformsWithOnePath'],
    ['label' => 'removeDimensions', 'value' => 'removeDimensions'],
    ['label' => 'removeAttrs', 'value' => 'removeAttrs'],
    ['label' => 'removeElementsByAttr', 'value' => 'removeElementsByAttr'],
    ['label' => 'addClassesToSVGElement', 'value' => 'addClassesToSVGElement'],
    ['label' => 'addAttributesToSVGElement', 'value' => 'addAttributesToSVGElement'],
    ['label' => 'removeStyleElement', 'value' => 'removeStyleElement'],
    ['label' => 'removeScriptElement', 'value' => 'removeScriptElement']
];

echo $Form->checkbox_set('svgo_plugins', 'Plugins', $plugin_opts, json_decode($OptimSettings->get('svgo_plugins', '[]')->value()));
