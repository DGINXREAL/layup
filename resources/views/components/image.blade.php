@if(!empty($data['src']))
<figure @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}" {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}>
    @if(!empty($data['link_url']))<a href="{{ $data['link_url'] }}" @if(!empty($data['link_new_tab']))target="_blank" rel="noopener noreferrer"@endif>@endif
    <img src="{{ is_array($data['src']) ? '' : asset('storage/' . $data['src']) }}" alt="{{ $data['alt'] ?? '' }}" class="max-w-full h-auto" />
    @if(!empty($data['link_url']))</a>@endif
    @if(!empty($data['caption']))
        <figcaption class="mt-2 text-sm text-gray-500 text-center">{{ $data['caption'] }}</figcaption>
    @endif
</figure>
@endif
