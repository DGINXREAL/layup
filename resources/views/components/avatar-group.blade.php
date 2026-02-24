@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $size = match($data['size'] ?? 'md') {
        'sm' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        default => 'w-10 h-10',
    };
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="flex items-center gap-3 {{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    <div class="flex -space-x-2">
        @foreach(($data['avatars'] ?? []) as $avatar)
            @if(!empty($avatar))
                <img src="{{ asset('storage/' . $avatar) }}" alt="" class="{{ $size }} rounded-full border-2 border-white object-cover" />
            @endif
        @endforeach
        @if(!empty($data['extra_count']))
            <div class="{{ $size }} rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-600">{{ $data['extra_count'] }}</div>
        @endif
    </div>
    @if(!empty($data['label']))
        <span class="text-sm text-gray-600">{{ $data['label'] }}</span>
    @endif
</div>
