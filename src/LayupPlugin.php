<?php

namespace Crumbls\Layup;

use Crumbls\Layup\Contracts\Widget;
use Crumbls\Layup\Resources\PageResource;
use Crumbls\Layup\Support\WidgetRegistry;
use Filament\Contracts\Plugin;
use Filament\Panel;

class LayupPlugin implements Plugin
{
    /** @var array<class-string<Widget>> Extra widgets registered via the plugin constructor */
    protected array $extraWidgets = [];

    /** @var array<class-string<Widget>> Widget types to remove from the registry */
    protected array $removedWidgets = [];

    /** @var bool Whether to load widgets from config */
    protected bool $useConfigWidgets = true;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public function getId(): string
    {
        return 'layup';
    }

    /**
     * Register additional widget classes.
     *
     * Usage in AdminPanelProvider:
     *   LayupPlugin::make()->widgets([MyCustomWidget::class, AnotherWidget::class])
     *
     * @param  array<class-string<Widget>>  $widgets
     */
    public function widgets(array $widgets): static
    {
        $this->extraWidgets = array_merge($this->extraWidgets, $widgets);
        return $this;
    }

    /**
     * Remove specific widget types from the registry.
     *
     * Usage:
     *   LayupPlugin::make()->withoutWidgets(['html', 'button'])
     *
     * @param  array<string>  $types  Widget type identifiers to remove
     */
    public function withoutWidgets(array $types): static
    {
        $this->removedWidgets = array_merge($this->removedWidgets, $types);
        return $this;
    }

    /**
     * Skip loading widgets from config (only use those passed via widgets()).
     */
    public function withoutConfigWidgets(): static
    {
        $this->useConfigWidgets = false;
        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            PageResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        $registry = app(WidgetRegistry::class);

        // Register config widgets (unless disabled)
        if ($this->useConfigWidgets) {
            foreach (config('layup.widgets', []) as $widget) {
                $registry->register($widget);
            }
        }

        // Register plugin-constructor widgets
        foreach ($this->extraWidgets as $widget) {
            $registry->register($widget);
        }

        // Remove excluded widgets
        foreach ($this->removedWidgets as $type) {
            $registry->unregister($type);
        }
    }
}
