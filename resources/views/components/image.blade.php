@if(!empty($data['src']))
<figure @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}" {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}>
    <img src="{{ is_array($data['src']) ? '' : asset('storage/' . $data['src']) }}" alt="{{ $data['alt'] ?? '' }}" class="max-w-full h-auto" />
    @if(!empty($data['caption']))
        <figcaption class="mt-2 text-sm text-gray-500 text-center">{{ $data['caption'] }}</figcaption>
    @endif
</figure>
@endif
