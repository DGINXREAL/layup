<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-gallery {{ $data['class'] ?? '' }}" style="display:grid;grid-template-columns:repeat({{ $data['columns'] ?? 3 }},1fr);gap:{{ $data['gap'] ?? '0.5rem' }}">
    @foreach(($data['images'] ?? []) as $image)
        @if(!empty($image))
            <div class="layup-gallery-item">
                <img src="{{ asset('storage/' . $image) }}" alt="" loading="lazy" style="width:100%;height:auto;display:block;border-radius:0.25rem" />
            </div>
        @endif
    @endforeach
</div>
