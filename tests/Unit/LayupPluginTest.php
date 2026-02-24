<?php

declare(strict_types=1);

use Crumbls\Layup\LayupPlugin;
use Crumbls\Layup\View\TextWidget;
use Crumbls\Layup\View\HeadingWidget;

it('getId() returns layup', function () {
    $plugin = new LayupPlugin();
    expect($plugin->getId())->toBe('layup');
});

it('widgets() adds widgets', function () {
    $plugin = new LayupPlugin();
    $result = $plugin->widgets([TextWidget::class]);
    expect($result)->toBeInstanceOf(LayupPlugin::class);
});

it('withoutWidgets() removes widgets', function () {
    $plugin = new LayupPlugin();
    $result = $plugin->withoutWidgets([TextWidget::class]);
    expect($result)->toBeInstanceOf(LayupPlugin::class);
});

it('withoutConfigWidgets() disables config loading', function () {
    $plugin = new LayupPlugin();
    $result = $plugin->withoutConfigWidgets();
    expect($result)->toBeInstanceOf(LayupPlugin::class);
});
