<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @if(!empty($data['cover']))
        <img src="{{ asset('storage/' . $data['cover']) }}" alt="{{ $data['title'] ?? '' }}" class="w-full h-auto rounded mb-3" />
    @endif
    @if(!empty($data['title']))
        <p class="font-semibold">{{ $data['title'] }}</p>
    @endif
    @if(!empty($data['artist']))
        <p class="text-sm text-gray-500 mb-2">{{ $data['artist'] }}</p>
    @endif
    @php $src = !empty($data['url']) ? $data['url'] : (!empty($data['file']) ? asset('storage/' . $data['file']) : ''); @endphp
    @if($src)
        <audio controls class="w-full" preload="metadata">
            <source src="{{ $src }}">
        </audio>
    @endif
</div>
