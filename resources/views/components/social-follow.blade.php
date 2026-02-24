<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="flex flex-wrap gap-3 {{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @foreach(($data['links'] ?? []) as $link)
        @if(!empty($link['url']))
            <a href="{{ $link['url'] }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors" @if($data['new_tab'] ?? true)target="_blank" rel="noopener noreferrer"@endif>
                <span>{{ ucfirst($link['network'] ?? '') }}</span>
            </a>
        @endif
    @endforeach
</div>
