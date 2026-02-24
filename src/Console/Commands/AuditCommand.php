<?php

declare(strict_types=1);

namespace Crumbls\Layup\Console\Commands;

use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Support\ContentValidator;
use Crumbls\Layup\Support\SafelistCollector;
use Crumbls\Layup\Support\WidgetRegistry;
use Illuminate\Console\Command;

class AuditCommand extends Command
{
    protected $signature = 'layup:audit';

    protected $description = 'Audit Layup pages — check for broken widgets, unused classes, and content issues';

    public function handle(): int
    {
        $modelClass = config('layup.pages.model', Page::class);
        $pages = $modelClass::all();

        $this->info('Layup Audit Report');
        $this->line(str_repeat('─', 40));
        $this->newLine();

        // Page stats
        $published = $pages->where('status', 'published')->count();
        $drafts = $pages->where('status', 'draft')->count();
        $this->line("📄 Pages: {$pages->count()} total ({$published} published, {$drafts} drafts)");

        // Widget registry
        $registry = app(WidgetRegistry::class);
        foreach (config('layup.widgets', []) as $class) {
            if (class_exists($class) && ! $registry->has($class::getType())) {
                $registry->register($class);
            }
        }
        $this->line('🧩 Registered widgets: ' . count($registry->all()));

        // Validate all pages
        $validator = new ContentValidator(strict: true);
        $issues = [];
        $widgetUsage = [];
        $totalWidgets = 0;

        foreach ($pages as $page) {
            $result = $validator->validate($page->content ?? ['rows' => []]);
            if (! $result->passes()) {
                $issues[$page->title] = $result->errors();
            }

            // Count widget usage
            foreach ($page->content['rows'] ?? [] as $row) {
                foreach ($row['columns'] ?? [] as $col) {
                    foreach ($col['widgets'] ?? [] as $widget) {
                        $type = $widget['type'] ?? 'unknown';
                        $widgetUsage[$type] = ($widgetUsage[$type] ?? 0) + 1;
                        $totalWidgets++;
                    }
                }
            }
        }

        $this->line("🔧 Total widget instances: {$totalWidgets}");

        // Widget usage breakdown
        if ($widgetUsage !== []) {
            arsort($widgetUsage);
            $this->newLine();
            $this->line('Widget usage:');
            foreach ($widgetUsage as $type => $count) {
                $registered = $registry->has($type) ? '✓' : '✗';
                $this->line("  {$registered} {$type}: {$count}");
            }
        }

        // Validation issues
        if ($issues !== []) {
            $this->newLine();
            $this->warn('⚠️  Content issues found:');
            foreach ($issues as $title => $errors) {
                $this->line("  {$title}:");
                foreach ($errors as $error) {
                    $this->line("    - {$error}");
                }
            }
        } else {
            $this->newLine();
            $this->info('✅ All pages pass content validation');
        }

        // Safelist status
        $staticCount = count(SafelistCollector::staticClasses());
        $allCount = count(SafelistCollector::classes());
        $dynamicCount = $allCount - $staticCount;
        $this->newLine();
        $this->line("🎨 Safelist: {$allCount} classes ({$staticCount} static + {$dynamicCount} dynamic)");

        // Revisions
        if (config('layup.revisions.enabled')) {
            $revisionCount = \Crumbls\Layup\Models\PageRevision::count();
            $this->line("📜 Revisions: {$revisionCount} total");
        }

        return self::SUCCESS;
    }
}
