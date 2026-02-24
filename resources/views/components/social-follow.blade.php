<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="flex flex-wrap gap-3 {{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}">
    @foreach(($data['links'] ?? []) as $link)
        @if(!empty($link['url']))
            <a href="{{ $link['url'] }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors" @if($data['new_tab'] ?? true)target="_blank" rel="noopener noreferrer"@endif>
                <span>{{ ucfirst($link['network'] ?? '') }}</span>
            </a>
        @endif
    @endforeach
</div>
