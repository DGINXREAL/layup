@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $cols = $data['columns'] ?? 3;
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="{{ $vis }} {{ $data['class'] ?? '' }}"
     style="display:grid;grid-template-columns:repeat({{ $cols }},1fr);gap:2rem; {{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    @foreach(($data['members'] ?? []) as $member)
        <div class="text-center">
            @php $photoSrc = $member['photo'] ?? $member['image'] ?? ''; @endphp
            @if(!empty($photoSrc))
                <img src="{{ str_starts_with($photoSrc, 'http') ? $photoSrc : asset('storage/' . $photoSrc) }}" alt="{{ $member['name'] ?? '' }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-3" />
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto mb-3 flex items-center justify-center text-gray-400 text-2xl">👤</div>
            @endif
            @if(!empty($member['name']))
                <div class="font-semibold">{{ $member['name'] }}</div>
            @endif
            @if(!empty($member['role']))
                <div class="text-sm text-gray-500">{{ $member['role'] }}</div>
            @endif
            @if(!empty($member['linkedin']) || !empty($member['twitter']))
                <div class="flex justify-center gap-2 mt-2 text-sm text-gray-400">
                    @if(!empty($member['linkedin']))<a href="{{ $member['linkedin'] }}" target="_blank" class="hover:text-blue-600">LinkedIn</a>@endif
                    @if(!empty($member['twitter']))<a href="{{ $member['twitter'] }}" target="_blank" class="hover:text-blue-400">Twitter</a>@endif
                </div>
            @endif
        </div>
    @endforeach
</div>
