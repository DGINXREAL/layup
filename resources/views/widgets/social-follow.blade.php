<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-social layup-social-{{ $data['style'] ?? 'icon' }} {{ $data['class'] ?? '' }}">
    @foreach(($data['links'] ?? []) as $link)
        @if(!empty($link['url']))
            <a href="{{ $link['url'] }}" class="layup-social-link layup-social-{{ $link['network'] ?? '' }}" @if($data['new_tab'] ?? true)target="_blank" rel="noopener noreferrer"@endif>
                <span>{{ ucfirst($link['network'] ?? '') }}</span>
            </a>
        @endif
    @endforeach
</div>
