<x-dynamic-component :component="$layout">
    <x-slot:title>{{ $page->getMetaTitle() }}</x-slot:title>

    <div class="space-y-4 my-4" @if($page->id) data-page-id="{{ $page->id }}" @endif>
        @foreach($tree as $row)
            {!! $row->render() !!}
        @endforeach
    </div>
</x-dynamic-component>
