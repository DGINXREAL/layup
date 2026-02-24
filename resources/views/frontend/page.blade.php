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
    </x-slot:meta>
    @endif

    <div class="space-y-4 my-4" @if($page->id) data-page-id="{{ $page->id }}" @endif>
        @foreach($tree as $row)
            {!! $row->render() !!}
        @endforeach
    </div>
    @layupScripts
</x-dynamic-component>
