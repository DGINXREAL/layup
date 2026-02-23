<div
    @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
    class="layup-column col-span-{{ $span['sm'] ?? 12 }} md:col-span-{{ $span['md'] ?? 12 }} lg:col-span-{{ $span['lg'] ?? 12 }} xl:col-span-{{ $span['xl'] ?? 12 }} {{ $data['class'] ?? '' }}"
    style="
        @if(!empty($data['align_self']) && $data['align_self'] !== 'auto')align-self: {{ $data['align_self'] === 'start' ? 'flex-start' : ($data['align_self'] === 'end' ? 'flex-end' : $data['align_self']) }};@endif
        @if(!empty($data['overflow']) && $data['overflow'] !== 'visible')overflow: {{ $data['overflow'] }};@endif
        @if(!empty($data['background_color']))background-color: {{ $data['background_color'] }};@endif
        @if(!empty($data['inline_css'])){{ $data['inline_css'] }}@endif
    "
>
    @foreach($children as $child)
        {!! $child->render() !!}
    @endforeach
</div>
