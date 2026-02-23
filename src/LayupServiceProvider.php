<?php

declare(strict_types=1);

namespace Crumbls\Layup;

use Crumbls\Layup\Support\WidgetRegistry;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class LayupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/layup.php', 'layup');

        $this->app->singleton(WidgetRegistry::class, fn () => new WidgetRegistry());
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'layup');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        FilamentAsset::register([
            Css::make('layup', __DIR__ . '/../resources/css/layup.css'),
        ]);

        $this->publishes([
            __DIR__ . '/../config/layup.php' => config_path('layup.php'),
        ], 'layup-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/layup'),
        ], 'layup-views');
    }
}
