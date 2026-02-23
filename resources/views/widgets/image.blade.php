@if(!empty($data['src']))
<figure class="layup-widget-image">
    <img src="{{ is_array($data['src']) ? '' : asset('storage/' . $data['src']) }}" alt="{{ $data['alt'] ?? '' }}" />
    @if(!empty($data['caption']))
        <figcaption>{{ $data['caption'] }}</figcaption>
    @endif
</figure>
@endif
