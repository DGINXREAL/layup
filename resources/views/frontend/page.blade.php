<x-dynamic-component :component="$layout">
    <x-slot:title>{{ $page->getMetaTitle() }}</x-slot:title>

    @if($page->meta['description'] ?? false)
    <x-slot:meta>
        <meta name="description" content="{{ $page->meta['description'] }}">
        <meta property="og:title" content="{{ $page->getMetaTitle() }}">
        <meta property="og:description" content="{{ $page->meta['description'] }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $page->getUrl() }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $page->getMetaTitle() }}">
        <meta name="twitter:description" content="{{ $page->meta['description'] }}">
        @if($page->meta['image'] ?? false)
        <meta property="og:image" content="{{ $page->meta['image'] }}">
        <meta name="twitter:image" content="{{ $page->meta['image'] }}">
        @endif
        <link rel="canonical" href="{{ $page->getUrl() }}">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_filter([
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                str_contains($page->slug, '/') ? ['@type' => 'ListItem', 'position' => 2, 'name' => ucfirst(explode('/', $page->slug)[0]), 'item' => url(config('layup.frontend.prefix', 'pages') . '/' . explode('/', $page->slug)[0])] : null,
                ['@type' => 'ListItem', 'position' => str_contains($page->slug, '/') ? 3 : 2, 'name' => $page->title],
            ]),
        ], JSON_UNESCAPED_SLASHES) !!}
        </script>
    </x-slot:meta>
    @endif

    <div @if($page->id) data-page-id="{{ $page->id }}" @endif>
        @foreach($sections as $section)
            @include('layup::components.section', ['section' => $section])
        @endforeach
    </div>
    @layupScripts
</x-dynamic-component>
