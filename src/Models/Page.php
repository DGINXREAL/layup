<?php

declare(strict_types=1);

namespace Crumbls\Layup\Models;

use Crumbls\Layup\Support\SafelistCollector;
use Crumbls\Layup\Support\WidgetRegistry;
use Crumbls\Layup\View\BaseView;
use Crumbls\Layup\View\Column;
use Crumbls\Layup\View\Row;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::saved(function (Page $page) {
            if (config('layup.safelist.enabled') && config('layup.safelist.auto_sync')) {
                SafelistCollector::sync();
            }
        });

        static::deleted(function (Page $page) {
            if (config('layup.safelist.enabled') && config('layup.safelist.auto_sync')) {
                SafelistCollector::sync();
            }
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta',
    ];

    /**
     * Use configurable table name so multiple dashboards can each
     * point to their own pages table.
     */
    public function getTable(): string
    {
        return config('layup.pages.table', 'layup_pages');
    }

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'meta' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /*
    |--------------------------------------------------------------------------
    | SEO Helpers
    |--------------------------------------------------------------------------
    */

    public function getMetaTitle(): string
    {
        return $this->meta['title'] ?? $this->title ?? '';
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta['description'] ?? null;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->meta['keywords'] ?? null;
    }

    /**
     * Get all meta as a flat array suitable for <meta> tags.
     */
    public function getMetaTags(): array
    {
        return array_filter([
            'title' => $this->getMetaTitle(),
            'description' => $this->getMetaDescription(),
            'keywords' => $this->getMetaKeywords(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | URL Generation
    |--------------------------------------------------------------------------
    */

    /**
     * Get the public-facing URL for this page.
     */
    public function getUrl(): string
    {
        $prefix = config('layup.frontend.prefix', 'pages');

        return url(ltrim("{$prefix}/{$this->slug}", '/'));
    }

    /*
    |--------------------------------------------------------------------------
    | CSS / Tailwind Safelist
    |--------------------------------------------------------------------------
    */

    /**
     * Get all Tailwind CSS classes used in this page's content.
     *
     * @return array<string>
     */
    public function getUsedClasses(): array
    {
        return SafelistCollector::classesFromContent($this->content);
    }

    /**
     * Get all inline CSS declarations used in this page's content.
     *
     * @return array<string>
     */
    public function getUsedInlineStyles(): array
    {
        return SafelistCollector::inlineStylesFromContent($this->content);
    }

    /*
    |--------------------------------------------------------------------------
    | Content Hydration
    |--------------------------------------------------------------------------
    */

    /**
     * Hydrate the stored JSON content into a tree of BaseView instances.
     *
     * Returns an array of Row objects, each containing Column children,
     * each containing widget children.
     *
     * @return array<Row>
     */
    public function getContentTree(): array
    {
        $content = $this->content ?? [];
        $rows = $content['rows'] ?? [];
        $registry = app(WidgetRegistry::class);

        return array_map(function (array $rowData) use ($registry) {
            $columns = array_map(function (array $colData) use ($registry) {
                $widgets = array_map(function (array $widgetData) use ($registry) {
                    $type = $widgetData['type'] ?? null;
                    $class = $type ? $registry->get($type) : null;

                    if (! $class) {
                        return null;
                    }

                    return $class::make($widgetData['data'] ?? []);
                }, $colData['widgets'] ?? []);

                $widgets = array_filter($widgets);

                return Column::make(
                    data: $colData['settings'] ?? [],
                    children: array_values($widgets),
                )->span($colData['span'] ?? 12);
            }, $rowData['columns'] ?? []);

            return Row::make(
                data: $rowData['settings'] ?? [],
                children: $columns,
            );
        }, $rows);
    }

    /**
     * Render the full page content to an HTML string.
     */
    public function toHtml(): string
    {
        $tree = $this->getContentTree();

        return implode("\n", array_map(
            fn (Row $row) => $row->render()->render(),
            $tree,
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */

    protected static function newFactory()
    {
        return \Crumbls\Layup\Database\Factories\PageFactory::new();
    }

    /**
     * Get sitemap entries for all published pages.
     * Returns an array of [url, lastmod, priority] suitable for sitemap generation.
     *
     * @return array<array{url: string, lastmod: string, priority: string}>
     */
    public static function sitemapEntries(): array
    {
        return static::published()->get()->map(function (self $page) {
            return [
                'url' => $page->getUrl(),
                'lastmod' => $page->updated_at->toDateString(),
                'priority' => '0.7',
            ];
        })->all();
    }
}
