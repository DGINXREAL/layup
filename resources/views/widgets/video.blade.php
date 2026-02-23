@if(!empty($data['url']))
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-video {{ $data['class'] ?? '' }}" style="aspect-ratio: {{ $data['aspect'] ?? '16/9' }}">
    <iframe src="{{ $data['embed_url'] ?? $data['url'] }}"
            frameborder="0"
            allowfullscreen
            @if(!empty($data['title'])) title="{{ $data['title'] }}" @endif
            @if(!empty($data['autoplay'])) allow="autoplay" @endif
            style="width: 100%; height: 100%;"></iframe>
</div>
@if(!empty($data['title']))
    <p class="layup-video-caption">{{ $data['title'] }}</p>
@endif
@endif
