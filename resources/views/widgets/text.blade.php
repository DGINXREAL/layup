<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-text {{ $data['class'] ?? '' }}">
    {!! $data['content'] ?? '' !!}
</div>
