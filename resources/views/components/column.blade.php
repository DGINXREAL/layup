<div class="layup-column col-span-{{ $span['sm'] ?? 12 }} md:col-span-{{ $span['md'] ?? 12 }} lg:col-span-{{ $span['lg'] ?? 12 }} xl:col-span-{{ $span['xl'] ?? 12 }} {{ $data['css_classes'] ?? '' }}"@if(!empty($data['padding'])) style="padding: {{ $data['padding'] }}"@endif>
    @foreach($children as $child)
        {!! $child->render() !!}
    @endforeach
</div>
