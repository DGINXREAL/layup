@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $cols = $data['columns'] ?? 4;
    $maxH = $data['max_height'] ?? '3rem';
    $gray = !empty($data['grayscale']);
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="{{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    @if(!empty($data['title']))
        <p class="text-center text-sm text-gray-500 uppercase tracking-wide mb-6">{{ $data['title'] }}</p>
    @endif
    <div style="display:grid;grid-template-columns:repeat({{ $cols }},1fr);gap:2rem;align-items:center;justify-items:center">
        @foreach(($data['logos'] ?? []) as $logo)
            @if(!empty($logo))
                <img src="{{ asset('storage/' . $logo) }}" alt="" style="max-height:{{ $maxH }};width:auto" class="{{ $gray ? 'grayscale hover:grayscale-0 opacity-60 hover:opacity-100' : '' }} transition-all duration-300" />
            @endif
        @endforeach
    </div>
</div>
