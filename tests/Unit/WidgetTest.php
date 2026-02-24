<?php

declare(strict_types=1);

use Crumbls\Layup\View\TextWidget;
use Crumbls\Layup\View\HeadingWidget;
use Crumbls\Layup\View\ImageWidget;
use Crumbls\Layup\View\ButtonWidget;
use Crumbls\Layup\View\VideoWidget;
use Crumbls\Layup\View\SpacerWidget;
use Crumbls\Layup\View\DividerWidget;
use Crumbls\Layup\View\HtmlWidget;
use Crumbls\Layup\View\BlurbWidget;
use Crumbls\Layup\View\IconWidget;
use Crumbls\Layup\View\AccordionWidget;
use Crumbls\Layup\View\ToggleWidget;
use Crumbls\Layup\View\TabsWidget;
use Crumbls\Layup\View\PersonWidget;
use Crumbls\Layup\View\TestimonialWidget;
use Crumbls\Layup\View\NumberCounterWidget;
use Crumbls\Layup\View\BarCounterWidget;
use Crumbls\Layup\View\GalleryWidget;
use Crumbls\Layup\View\AudioWidget;
use Crumbls\Layup\View\SliderWidget;
use Crumbls\Layup\View\MapWidget;
use Crumbls\Layup\View\CallToActionWidget;
use Crumbls\Layup\View\CountdownWidget;
use Crumbls\Layup\View\PricingTableWidget;
use Crumbls\Layup\View\SocialFollowWidget;
use Crumbls\Layup\View\CodeWidget;
use Crumbls\Layup\View\AlertWidget;
use Crumbls\Layup\View\TableWidget;
use Crumbls\Layup\View\EmbedWidget;
use Crumbls\Layup\View\ProgressCircleWidget;
use Crumbls\Layup\View\MenuWidget;
use Crumbls\Layup\View\SearchWidget;
use Crumbls\Layup\View\ContactFormWidget;

$widgets = [
    TextWidget::class,
    HeadingWidget::class,
    ImageWidget::class,
    ButtonWidget::class,
    VideoWidget::class,
    SpacerWidget::class,
    DividerWidget::class,
    HtmlWidget::class,
    BlurbWidget::class,
    IconWidget::class,
    AccordionWidget::class,
    ToggleWidget::class,
    TabsWidget::class,
    PersonWidget::class,
    TestimonialWidget::class,
    NumberCounterWidget::class,
    BarCounterWidget::class,
    GalleryWidget::class,
    AudioWidget::class,
    SliderWidget::class,
    MapWidget::class,
    CallToActionWidget::class,
    CountdownWidget::class,
    PricingTableWidget::class,
    SocialFollowWidget::class,
    CodeWidget::class,
    AlertWidget::class,
    TableWidget::class,
    EmbedWidget::class,
    ProgressCircleWidget::class,
    MenuWidget::class,
    SearchWidget::class,
    ContactFormWidget::class,
];

foreach ($widgets as $widgetClass) {
    $shortName = class_basename($widgetClass);

    it("{$shortName}::getType() returns non-empty string", function () use ($widgetClass) {
        expect($widgetClass::getType())->toBeString()->not->toBeEmpty();
    });

    it("{$shortName}::getLabel() returns non-empty string", function () use ($widgetClass) {
        expect($widgetClass::getLabel())->toBeString()->not->toBeEmpty();
    });

    it("{$shortName}::getIcon() returns heroicon string", function () use ($widgetClass) {
        expect($widgetClass::getIcon())->toBeString()->toStartWith('heroicon-');
    });

    it("{$shortName}::getCategory() is one of the allowed categories", function () use ($widgetClass) {
        expect($widgetClass::getCategory())->toBeIn(['content', 'media', 'layout', 'interactive', 'advanced']);
    });

    it("{$shortName}::getFormSchema() returns array with Tabs", function () use ($widgetClass) {
        $schema = $widgetClass::getFormSchema();
        expect($schema)->toBeArray()->not->toBeEmpty();
        expect($schema[0])->toBeInstanceOf(\Filament\Schemas\Components\Tabs::class);
    });

    it("{$shortName}::getContentFormSchema() returns array", function () use ($widgetClass) {
        expect($widgetClass::getContentFormSchema())->toBeArray();
    });

    it("{$shortName}::getDefaultData() returns array", function () use ($widgetClass) {
        expect($widgetClass::getDefaultData())->toBeArray();
    });

    it("{$shortName}::getPreview() with default data returns string", function () use ($widgetClass) {
        $data = $widgetClass::getDefaultData();
        expect($widgetClass::getPreview($data))->toBeString();
    });

    it("{$shortName}::toArray() has required keys", function () use ($widgetClass) {
        $arr = $widgetClass::toArray();
        expect($arr)->toHaveKeys(['type', 'label', 'icon', 'category', 'defaults']);
    });
}
