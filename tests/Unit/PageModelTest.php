<?php

declare(strict_types=1);

use Crumbls\Layup\Events\SafelistChanged;
use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Support\SafelistCollector;
use Illuminate\Support\Facades\Event;

it('creates a page with title/slug/content/status', function () {
    $page = Page::create([
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => ['rows' => []],
        'status' => 'draft',
    ]);
    expect($page)->toBeInstanceOf(Page::class);
    expect($page->title)->toBe('Test Page');
    expect($page->slug)->toBe('test-page');
    expect($page->status)->toBe('draft');
});

it('casts content to array', function () {
    $page = Page::create([
        'title' => 'T', 'slug' => 'cast-content',
        'content' => ['rows' => [['columns' => []]]],
        'status' => 'draft',
    ]);
    $fresh = $page->fresh();
    expect($fresh->content)->toBeArray();
    expect($fresh->content['rows'])->toHaveCount(1);
});

it('casts meta to array', function () {
    $page = Page::create([
        'title' => 'T', 'slug' => 'cast-meta',
        'content' => null,
        'status' => 'draft',
        'meta' => ['description' => 'hello'],
    ]);
    expect($page->fresh()->meta)->toBeArray()->toHaveKey('description');
});

it('scopePublished filters correctly', function () {
    Page::create(['title' => 'A', 'slug' => 'a', 'status' => 'published']);
    Page::create(['title' => 'B', 'slug' => 'b', 'status' => 'draft']);
    expect(Page::published()->count())->toBe(1);
});

it('scopeDraft filters correctly', function () {
    Page::create(['title' => 'A', 'slug' => 'a2', 'status' => 'published']);
    Page::create(['title' => 'B', 'slug' => 'b2', 'status' => 'draft']);
    expect(Page::draft()->count())->toBe(1);
});

it('supports soft deletes', function () {
    $page = Page::create(['title' => 'Del', 'slug' => 'del', 'status' => 'draft']);
    $page->delete();
    expect(Page::where('slug', 'del')->count())->toBe(0);
    expect(Page::withTrashed()->where('slug', 'del')->count())->toBe(1);
});

it('enforces slug uniqueness', function () {
    Page::create(['title' => 'A', 'slug' => 'unique-slug', 'status' => 'draft']);
    Page::create(['title' => 'B', 'slug' => 'unique-slug', 'status' => 'draft']);
})->throws(\Illuminate\Database\QueryException::class);

it('stores and retrieves complex content JSON', function () {
    $content = [
        'rows' => [
            [
                'id' => 'row_1',
                'columns' => [
                    [
                        'id' => 'col_1',
                        'span' => ['sm' => 12, 'md' => 6, 'lg' => 6, 'xl' => 6],
                        'widgets' => [
                            ['id' => 'w_1', 'type' => 'text', 'data' => ['content' => '<p>Hi</p>']],
                        ],
                    ],
                ],
            ],
        ],
    ];
    $page = Page::create(['title' => 'Complex', 'slug' => 'complex', 'status' => 'draft', 'content' => $content]);
    $fresh = $page->fresh();
    expect($fresh->content['rows'][0]['columns'][0]['widgets'][0]['type'])->toBe('text');
});

it('reads table name from config', function () {
    $page = new Page();
    expect($page->getTable())->toBe(config('layup.pages.table', 'layup_pages'));
});

it('getUrl() returns the correct URL', function () {
    $page = Page::create(['title' => 'Url', 'slug' => 'my-page', 'status' => 'draft']);
    expect($page->getUrl())->toEndWith('/pages/my-page');
});

it('getMetaTitle() falls back to title', function () {
    $page = Page::create(['title' => 'Fallback', 'slug' => 'meta-title', 'status' => 'draft']);
    expect($page->getMetaTitle())->toBe('Fallback');
});

it('getMetaTitle() uses meta title when set', function () {
    $page = Page::create([
        'title' => 'Fallback', 'slug' => 'meta-title2', 'status' => 'draft',
        'meta' => ['title' => 'Custom Title'],
    ]);
    expect($page->getMetaTitle())->toBe('Custom Title');
});

it('getMetaDescription() returns description from meta', function () {
    $page = Page::create([
        'title' => 'D', 'slug' => 'meta-desc', 'status' => 'draft',
        'meta' => ['description' => 'A desc'],
    ]);
    expect($page->getMetaDescription())->toBe('A desc');
});

it('getMetaKeywords() returns keywords from meta', function () {
    $page = Page::create([
        'title' => 'K', 'slug' => 'meta-kw', 'status' => 'draft',
        'meta' => ['keywords' => 'a,b,c'],
    ]);
    expect($page->getMetaKeywords())->toBe('a,b,c');
});

it('dispatches SafelistChanged when saving a page adds new classes', function () {
    Event::fake([SafelistChanged::class]);

    // Seed cache with a minimal class list so the new page triggers a change
    cache()->put('layup:safelist:hash', 'stale');
    cache()->put('layup:safelist:classes', ['flex', 'flex-wrap']);

    config(['layup.safelist.enabled' => true, 'layup.safelist.auto_sync' => true]);

    Page::create([
        'title' => 'Safelist Test',
        'slug' => 'safelist-test',
        'content' => ['rows' => [['id' => 'r1', 'settings' => [], 'columns' => [['id' => 'c1', 'span' => ['sm' => 6], 'settings' => ['class' => 'my-custom-class'], 'widgets' => []]]]]],
        'status' => 'published',
    ]);

    Event::assertDispatched(SafelistChanged::class, function (SafelistChanged $e) {
        return in_array('my-custom-class', $e->added);
    });
});

it('does not dispatch SafelistChanged when safelist is unchanged', function () {
    Event::fake([SafelistChanged::class]);

    config(['layup.safelist.enabled' => true, 'layup.safelist.auto_sync' => true]);

    // Generate the initial safelist
    SafelistCollector::sync();

    // Save a page with no custom classes — safelist shouldn't change
    Page::create([
        'title' => 'No Change',
        'slug' => 'no-change',
        'content' => ['rows' => []],
        'status' => 'draft',
    ]);

    // The first sync dispatched and cached the hash, the second (from save)
    // should not dispatch since draft pages aren't in published scope
    // and the hash hasn't changed
    Event::assertDispatchedTimes(SafelistChanged::class, 1);
});

it('does not sync safelist when auto_sync is disabled', function () {
    Event::fake([SafelistChanged::class]);

    config(['layup.safelist.enabled' => true, 'layup.safelist.auto_sync' => false]);

    Page::create([
        'title' => 'No Sync',
        'slug' => 'no-sync',
        'content' => ['rows' => [['id' => 'r1', 'settings' => ['class' => 'special'], 'columns' => []]]],
        'status' => 'published',
    ]);

    Event::assertNotDispatched(SafelistChanged::class);
});
