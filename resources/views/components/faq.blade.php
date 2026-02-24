@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $items = $data['items'] ?? [];
    $collapsible = !empty($data['collapsible']);
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="{{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    @if(!empty($data['title']))
        <h2 class="text-2xl font-bold mb-6">{{ $data['title'] }}</h2>
    @endif
    <div class="space-y-3">
        @foreach($items as $i => $item)
            @if($collapsible)
                <div x-data="{ open: false }" class="border rounded-lg">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-left font-medium hover:bg-gray-50 transition-colors">
                        <span>{{ $item['question'] ?? '' }}</span>
                        <span class="transform transition-transform" :class="open ? 'rotate-180' : ''">▼</span>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-3 text-gray-600">{{ $item['answer'] ?? '' }}</div>
                </div>
            @else
                <div class="border rounded-lg px-4 py-3">
                    <h3 class="font-medium mb-1">{{ $item['question'] ?? '' }}</h3>
                    <p class="text-gray-600">{{ $item['answer'] ?? '' }}</p>
                </div>
            @endif
        @endforeach
    </div>

    @if(!empty($data['schema_markup']) && count($items) > 0)
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn($item) => [
                '@type' => 'Question',
                'name' => $item['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'] ?? '',
                ],
            ], $items),
        ], JSON_UNESCAPED_SLASHES) !!}
        </script>
    @endif
</div>
