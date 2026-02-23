<{{ $data['level'] ?? 'h2' }} @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-heading {{ $data['class'] ?? '' }}">
    {{ $data['content'] ?? '' }}
</{{ $data['level'] ?? 'h2' }}>
