@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $type = $data['type'] ?? 'info';
    $colors = match($type) {
        'success' => 'bg-green-50 border-green-500 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-500 text-yellow-800',
        'danger'  => 'bg-red-50 border-red-500 text-red-800',
        default   => 'bg-blue-50 border-blue-500 text-blue-800',
    };
    $icon = match($type) {
        'success' => '✓',
        'warning' => '⚠',
        'danger'  => '✕',
        default   => 'ℹ',
    };
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="border-l-4 p-4 rounded-r {{ $colors }} {{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
     @if(!empty($data['dismissible'])) x-data="{ show: true }" x-show="show" x-transition @endif
>
    <div class="flex items-start gap-3">
        <span class="text-lg font-bold shrink-0">{{ $icon }}</span>
        <div class="flex-1">
            @if(!empty($data['title']))
                <div class="font-semibold mb-1">{{ $data['title'] }}</div>
            @endif
            @if(!empty($data['content']))
                <div class="text-sm">{!! $data['content'] !!}</div>
            @endif
        </div>
        @if(!empty($data['dismissible']))
            <button @click="show = false" class="text-current opacity-50 hover:opacity-100 shrink-0">&times;</button>
        @endif
    </div>
</div>
