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
        // Content
        \Crumbls\Layup\View\TextWidget::class,
        \Crumbls\Layup\View\HeadingWidget::class,
        \Crumbls\Layup\View\BlurbWidget::class,
        \Crumbls\Layup\View\IconWidget::class,
        \Crumbls\Layup\View\AccordionWidget::class,
        \Crumbls\Layup\View\ToggleWidget::class,
        \Crumbls\Layup\View\TabsWidget::class,
        \Crumbls\Layup\View\PersonWidget::class,
        \Crumbls\Layup\View\TestimonialWidget::class,
        \Crumbls\Layup\View\NumberCounterWidget::class,
        \Crumbls\Layup\View\BarCounterWidget::class,

        // Media
        \Crumbls\Layup\View\ImageWidget::class,
        \Crumbls\Layup\View\GalleryWidget::class,
        \Crumbls\Layup\View\VideoWidget::class,
        \Crumbls\Layup\View\AudioWidget::class,
        \Crumbls\Layup\View\SliderWidget::class,
        \Crumbls\Layup\View\MapWidget::class,

        // Interactive
        \Crumbls\Layup\View\ButtonWidget::class,
        \Crumbls\Layup\View\CallToActionWidget::class,
        \Crumbls\Layup\View\CountdownWidget::class,
        \Crumbls\Layup\View\PricingTableWidget::class,
        \Crumbls\Layup\View\SocialFollowWidget::class,

        // Layout
        \Crumbls\Layup\View\SpacerWidget::class,
        \Crumbls\Layup\View\DividerWidget::class,

        // Advanced
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
