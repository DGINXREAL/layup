<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Registered Widgets
    |--------------------------------------------------------------------------
    |
    | Widget classes available in the page builder. Each must extend
    | Crumbls\Layup\View\BaseWidget.
    |
    */
    'widgets' => [
        \Crumbls\Layup\View\TextWidget::class,
        \Crumbls\Layup\View\HeadingWidget::class,
        \Crumbls\Layup\View\ImageWidget::class,
        \Crumbls\Layup\View\ButtonWidget::class,
        \Crumbls\Layup\View\VideoWidget::class,
        \Crumbls\Layup\View\SpacerWidget::class,
        \Crumbls\Layup\View\DividerWidget::class,
        \Crumbls\Layup\View\HtmlWidget::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Breakpoints
    |--------------------------------------------------------------------------
    |
    | Responsive preview breakpoints shown in the size toggler.
    |
    */
    'breakpoints' => [
        'sm' => ['label' => 'sm', 'width' => 640, 'icon' => 'heroicon-o-device-phone-mobile'],
        'md' => ['label' => 'md', 'width' => 768, 'icon' => 'heroicon-o-device-tablet'],
        'lg' => ['label' => 'lg', 'width' => 1024, 'icon' => 'heroicon-o-computer-desktop'],
        'xl' => ['label' => 'xl', 'width' => 1280, 'icon' => 'heroicon-o-tv'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Breakpoint
    |--------------------------------------------------------------------------
    */
    'default_breakpoint' => 'lg',

    /*
    |--------------------------------------------------------------------------
    | Row Templates
    |--------------------------------------------------------------------------
    |
    | Predefined column layouts for the "Add Row" picker.
    | Each is an array of column spans (must sum to 12).
    |
    */
    'row_templates' => [
        [12],
        [6, 6],
        [4, 4, 4],
        [3, 3, 3, 3],
        [8, 4],
        [4, 8],
        [3, 6, 3],
        [2, 8, 2],
    ],
];
