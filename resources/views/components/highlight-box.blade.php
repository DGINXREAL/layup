@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $v = $data['variant'] ?? 'info';
    $styles = match($v) {
        'tip' => 'bg-green-50 border-green-300 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800',
        'important' => 'bg-red-50 border-red-300 text-red-800',
        'note' => 'bg-gray-50 border-gray-300 text-gray-700',
        default => 'bg-blue-50 border-blue-300 text-blue-800',
    };
    $icons = match($v) {
        'tip' => '💚', 'warning' => '⚠️', 'important' => '❗', 'note' => '📝', default => '💡',
    };
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="border-l-4 rounded-r-lg p-4 {{ $styles }} {{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    <div class="flex gap-2 items-start">
        <span class="text-lg">{{ $data['icon'] ?? $icons }}</span>
        <div>
            @if(!empty($data['title']))<div class="font-semibold mb-1">{{ $data['title'] }}</div>@endif
            @if(!empty($data['content']))<div class="prose prose-sm">{!! $data['content'] !!}</div>@endif
        </div>
    </div>
</div>
