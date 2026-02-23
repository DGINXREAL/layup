<div class="layup-row grid grid-cols-12 {{ $data['gap'] ?? 'gap-4' }} {{ $data['css_classes'] ?? '' }}"@if(!empty($data['alignment'])) style="justify-content: {{ $data['alignment'] }}"@endif>
    @foreach($children as $child)
        {!! $child->render() !!}
    @endforeach
</div>
