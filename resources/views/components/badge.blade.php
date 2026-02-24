@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $variant = $data['variant'] ?? 'default';
    $size = $data['size'] ?? 'md';
    $colors = match($variant) {
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
        'info' => 'bg-blue-100 text-blue-800',
        'dark' => 'bg-gray-800 text-white',
        default => 'bg-gray-100 text-gray-800',
    };
    $sizeClass = match($size) {
        'sm' => 'text-xs px-2 py-0.5',
        'lg' => 'text-base px-4 py-1.5',
        default => 'text-sm px-3 py-1',
    };
    $tag = !empty($data['link_url']) ? 'a' : 'span';
@endphp
<{{ $tag }}
    @if(!empty($data['link_url']))href="{{ $data['link_url'] }}"@endif
    @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
    class="inline-block rounded-full font-medium {{ $colors }} {{ $sizeClass }} {{ $vis }} {{ $data['class'] ?? '' }}"
    style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
    {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>{{ $data['text'] ?? '' }}</{{ $tag }}>
