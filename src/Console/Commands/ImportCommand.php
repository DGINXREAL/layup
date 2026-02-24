<?php

declare(strict_types=1);

namespace Crumbls\Layup\Console\Commands;

use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Support\ContentValidator;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'layup:import
                            {file : JSON file to import}
                            {--dry-run : Validate without importing}
                            {--overwrite : Overwrite existing pages by slug}';

    protected $description = 'Import Layup pages from a JSON export file';

    public function handle(): int
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return self::FAILURE;
        }

        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data) || !isset($data['pages'])) {
            $this->error('Invalid export file — expected { "pages": [...] }');
            return self::FAILURE;
        }

        $modelClass = config('layup.pages.model', Page::class);
        $validator = new ContentValidator();
        $imported = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($data['pages'] as $pageData) {
            $slug = $pageData['slug'] ?? null;
            if (!$slug) {
                $this->warn('Skipping page without slug');
                $skipped++;
                continue;
            }

            // Validate content
            $result = $validator->validate($pageData['content'] ?? ['rows' => []]);
            if (!$result->passes()) {
                $this->warn("Invalid content for '{$slug}': " . implode(', ', $result->errors()));
                $errors++;
                continue;
            }

            if ($this->option('dry-run')) {
                $this->line("✓ {$slug} — valid");
                $imported++;
                continue;
            }

            $existing = $modelClass::withTrashed()->where('slug', $slug)->first();

            if ($existing && !$this->option('overwrite')) {
                $this->warn("Skipping '{$slug}' (already exists, use --overwrite)");
                $skipped++;
                continue;
            }

            if ($existing) {
                $existing->update([
                    'title' => $pageData['title'] ?? $existing->title,
                    'content' => $pageData['content'] ?? $existing->content,
                    'meta' => $pageData['meta'] ?? $existing->meta,
                    'status' => $pageData['status'] ?? $existing->status,
                ]);
                $this->info("Updated: {$slug}");
            } else {
                $modelClass::create([
                    'title' => $pageData['title'] ?? ucfirst($slug),
                    'slug' => $slug,
                    'content' => $pageData['content'] ?? ['rows' => []],
                    'meta' => $pageData['meta'] ?? [],
                    'status' => $pageData['status'] ?? 'draft',
                ]);
                $this->info("Created: {$slug}");
            }

            $imported++;
        }

        $this->newLine();
        $action = $this->option('dry-run') ? 'Validated' : 'Imported';
        $this->info("{$action}: {$imported} | Skipped: {$skipped} | Errors: {$errors}");

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }
}
