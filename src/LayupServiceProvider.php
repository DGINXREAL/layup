<?php

declare(strict_types=1);

namespace Crumbls\Layup;

use Crumbls\Layup\Console\Commands\GenerateSafelist;
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

        if ($this->app->runningInConsole()) {
            $this->commands([GenerateSafelist::class]);
        }

        if (config('layup.frontend.enabled', true)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        FilamentAsset::register([
            Css::make('layup', __DIR__ . '/../resources/css/layup.css'),
        ], 'crumbls/layup');

        $this->publishes([
            __DIR__ . '/../config/layup.php' => config_path('layup.php'),
        ], 'layup-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/layup'),
        ], 'layup-views');

        $this->publishes([
            __DIR__ . '/../routes/web.php' => base_path('routes/layup.php'),
        ], 'layup-routes');
    }
}
