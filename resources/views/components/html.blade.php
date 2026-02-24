<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    {!! $data['content'] ?? '' !!}
</div>
