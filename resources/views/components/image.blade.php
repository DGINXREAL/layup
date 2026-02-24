@if(!empty($data['src']))
<figure @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    <img src="{{ is_array($data['src']) ? '' : asset('storage/' . $data['src']) }}" alt="{{ $data['alt'] ?? '' }}" class="max-w-full h-auto" />
    @if(!empty($data['caption']))
        <figcaption class="mt-2 text-sm text-gray-500 text-center">{{ $data['caption'] }}</figcaption>
    @endif
</figure>
@endif
