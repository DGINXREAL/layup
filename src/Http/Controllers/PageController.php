<?php

declare(strict_types=1);

namespace Crumbls\Layup\Http\Controllers;

use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Support\WidgetRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Invokable controller that resolves pages by slug.
 *
 * Supports:
 *  - Exact slug match: /pages/about
 *  - Nested/wildcard slugs: /pages/docs/getting-started (slug = "docs/getting-started")
 *  - Configurable route prefix and layout
 *  - Custom model class via config
 */
class PageController extends Controller
{
    public function __invoke(Request $request, string $slug = ''): Response
    {
        $this->ensureWidgetsRegistered();

        $modelClass = config('layup.pages.model', Page::class);

        $page = $modelClass::query()
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $layout = config('layup.frontend.layout', 'layup::layouts.page');
        $view = config('layup.frontend.view', 'layup::frontend.page');

        $tree = $page->getContentTree();

        return response(
            view($view, [
                'page' => $page,
                'tree' => $tree,
                'layout' => $layout,
            ])->render()
        );
    }

    /**
     * Ensure the widget registry is populated from config.
     * In Filament panel context, LayupPlugin handles this.
     * On frontend routes, we do it here.
     */
    protected function ensureWidgetsRegistered(): void
    {
        $registry = app(WidgetRegistry::class);

        if (count($registry->all()) > 0) {
            return;
        }

        foreach (config('layup.widgets', []) as $widgetClass) {
            $registry->register($widgetClass);
        }
    }
}
