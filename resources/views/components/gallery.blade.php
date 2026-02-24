<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" style="display:grid;grid-template-columns:repeat({{ $data['columns'] ?? 3 }},1fr);gap:{{ $data['gap'] ?? '0.5rem' }};@if(!empty($data['inline_css'])){{ $data['inline_css'] }}@endif">
    @foreach(($data['images'] ?? []) as $image)
        @if(!empty($image))
            <div class="overflow-hidden rounded">
                <img src="{{ asset('storage/' . $image) }}" alt="" loading="lazy" class="w-full h-auto block hover:scale-105 transition-transform duration-300" />
            </div>
        @endif
    @endforeach
</div>
