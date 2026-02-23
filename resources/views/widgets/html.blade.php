<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-html {{ $data['class'] ?? '' }}">
    {!! $data['content'] ?? '' !!}
</div>
