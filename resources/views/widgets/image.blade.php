@if(!empty($data['src']))
<figure @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-image {{ $data['class'] ?? '' }}">
    <img src="{{ is_array($data['src']) ? '' : asset('storage/' . $data['src']) }}" alt="{{ $data['alt'] ?? '' }}" />
    @if(!empty($data['caption']))
        <figcaption>{{ $data['caption'] }}</figcaption>
    @endif
</figure>
@endif
