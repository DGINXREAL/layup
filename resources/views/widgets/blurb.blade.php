<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-blurb layup-blurb-{{ $data['layout'] ?? 'top' }} {{ $data['class'] ?? '' }}">
    @if(($data['media_type'] ?? 'none') === 'image' && !empty($data['image']))
        <div class="layup-blurb-media">
            <img src="{{ asset('storage/' . $data['image']) }}" alt="{{ $data['title'] ?? '' }}" />
        </div>
    @endif
    <div class="layup-blurb-content">
        @if(!empty($data['title']))
            @if(!empty($data['url']))<a href="{{ $data['url'] }}">@endif
            <h3>{{ $data['title'] }}</h3>
            @if(!empty($data['url']))</a>@endif
        @endif
        @if(!empty($data['content']))
            <div>{!! $data['content'] !!}</div>
        @endif
    </div>
</div>
