<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-cta {{ $data['class'] ?? '' }}">
    @if(!empty($data['title']))
        <h2>{{ $data['title'] }}</h2>
    @endif
    @if(!empty($data['content']))
        <div>{!! $data['content'] !!}</div>
    @endif
    @if(!empty($data['button_text']))
        <a href="{{ $data['button_url'] ?? '#' }}" class="layup-cta-button">{{ $data['button_text'] }}</a>
    @endif
</div>
