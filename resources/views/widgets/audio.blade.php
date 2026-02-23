<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-audio {{ $data['class'] ?? '' }}">
    @if(!empty($data['cover']))
        <img src="{{ asset('storage/' . $data['cover']) }}" alt="{{ $data['title'] ?? '' }}" class="layup-audio-cover" />
    @endif
    @if(!empty($data['title']))
        <div class="layup-audio-title">{{ $data['title'] }}</div>
    @endif
    @if(!empty($data['artist']))
        <div class="layup-audio-artist">{{ $data['artist'] }}</div>
    @endif
    @php $src = !empty($data['file']) ? asset('storage/' . $data['file']) : ($data['url'] ?? ''); @endphp
    @if($src)
        <audio controls preload="metadata" style="width:100%">
            <source src="{{ $src }}">
        </audio>
    @endif
</div>
