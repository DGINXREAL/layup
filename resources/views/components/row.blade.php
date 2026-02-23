<div
    @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
    class="layup-row flex {{ $data['wrap'] ?? 'flex-wrap' }} {{ $data['gap'] ?? 'gap-4' }} {{ $data['class'] ?? '' }}"
    style="
        flex-direction: {{ $data['direction'] ?? 'row' }};
        justify-content: {{ match($data['justify'] ?? 'start') { 'start' => 'flex-start', 'end' => 'flex-end', 'center' => 'center', 'between' => 'space-between', 'around' => 'space-around', 'evenly' => 'space-evenly', default => 'flex-start' } }};
        align-items: {{ match($data['align'] ?? 'stretch') { 'start' => 'flex-start', 'end' => 'flex-end', 'center' => 'center', 'stretch' => 'stretch', 'baseline' => 'baseline', default => 'stretch' } }};
        @if(!empty($data['background_color']))background-color: {{ $data['background_color'] }};@endif
        @if(!empty($data['inline_css'])){{ $data['inline_css'] }}@endif
    "
>
    @foreach($children as $child)
        {!! $child->render() !!}
    @endforeach
</div>
