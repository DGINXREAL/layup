<?php

declare(strict_types=1);

use Crumbls\Layup\Support\WidgetContext;
use Crumbls\Layup\Support\WidgetRegistry;
use Crumbls\Layup\View\TextWidget;
use Crumbls\Layup\View\HeadingWidget;

beforeEach(function () {
    $this->registry = new WidgetRegistry();
});

it('registers a widget and retrieves by type', function () {
    $this->registry->register(TextWidget::class);
    expect($this->registry->get('text'))->toBe(TextWidget::class);
});

it('has() returns true for registered and false for unregistered', function () {
    $this->registry->register(TextWidget::class);
    expect($this->registry->has('text'))->toBeTrue();
    expect($this->registry->has('nonexistent'))->toBeFalse();
});

it('unregister() removes a widget', function () {
    $this->registry->register(TextWidget::class);
    $this->registry->unregister('text');
    expect($this->registry->has('text'))->toBeFalse();
});

it('all() returns all registered widgets', function () {
    $this->registry->register(TextWidget::class);
    $this->registry->register(HeadingWidget::class);
    expect($this->registry->all())->toHaveCount(2)
        ->toHaveKeys(['text', 'heading']);
});

it('toJs() returns correct array structure', function () {
    $this->registry->register(TextWidget::class);
    $js = $this->registry->toJs();
    expect($js)->toBeArray()->toHaveCount(1);
    expect($js[0])->toHaveKeys(['type', 'label', 'icon', 'category', 'defaults']);
    expect($js[0]['type'])->toBe('text');
});

it('grouped() groups by category', function () {
    $this->registry->register(TextWidget::class);
    $this->registry->register(HeadingWidget::class);
    $grouped = $this->registry->grouped();
    expect($grouped)->toHaveKey('content');
    expect($grouped['content'])->toHaveCount(2);
});

it('throws InvalidArgumentException for non-Widget class', function () {
    $this->registry->register(\stdClass::class);
})->throws(\InvalidArgumentException::class);

it('getFormSchema() returns array for known type', function () {
    $this->registry->register(TextWidget::class);
    expect($this->registry->getFormSchema('text'))->toBeArray()->not->toBeEmpty();
});

it('getFormSchema() returns empty array for unknown type', function () {
    expect($this->registry->getFormSchema('unknown'))->toBe([]);
});

it('getDefaultData() returns defaults', function () {
    $this->registry->register(TextWidget::class);
    expect($this->registry->getDefaultData('text'))->toBeArray()->toHaveKey('content');
});

it('getPreview() returns preview text', function () {
    $this->registry->register(TextWidget::class);
    expect($this->registry->getPreview('text', ['content' => 'Hello']))->toBe('Hello');
});

it('fireOnCreate() calls onCreate', function () {
    $this->registry->register(TextWidget::class);
    $result = $this->registry->fireOnCreate('text', ['content' => 'test']);
    expect($result)->toBeArray()->toHaveKey('content');
});

it('fireOnSave() calls onSave', function () {
    $this->registry->register(TextWidget::class);
    $result = $this->registry->fireOnSave('text', ['content' => 'test']);
    expect($result)->toBeArray();
});

it('fireOnDelete() calls onDelete without error', function () {
    $this->registry->register(TextWidget::class);
    $this->registry->fireOnDelete('text', ['content' => 'test']);
    expect(true)->toBeTrue(); // no exception
});

it('fireOnSave() accepts optional WidgetContext', function () {
    $this->registry->register(TextWidget::class);
    $ctx = new WidgetContext(null, 'r1', 'c1', 'w1');
    $result = $this->registry->fireOnSave('text', ['content' => 'hi'], $ctx);
    expect($result)->toBeArray()->toHaveKey('content');
});

it('fireOnCreate() accepts optional WidgetContext', function () {
    $this->registry->register(TextWidget::class);
    $ctx = new WidgetContext(null, 'r1', 'c1', 'w1');
    $result = $this->registry->fireOnCreate('text', ['content' => 'hi'], $ctx);
    expect($result)->toBeArray();
});

it('fireOnDelete() accepts optional WidgetContext', function () {
    $this->registry->register(TextWidget::class);
    $ctx = new WidgetContext(null, 'r1', 'c1', 'w1');
    $this->registry->fireOnDelete('text', ['content' => 'hi'], $ctx);
    expect(true)->toBeTrue();
});
