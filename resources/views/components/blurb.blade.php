<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="{{ ($data['layout'] ?? 'top') === 'left' ? 'flex gap-4' : '' }} {{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @if(($data['media_type'] ?? 'none') === 'image' && !empty($data['image']))
        <div class="{{ ($data['layout'] ?? 'top') === 'left' ? 'shrink-0' : 'mb-4' }}">
            <img src="{{ asset('storage/' . $data['image']) }}" alt="{{ $data['title'] ?? '' }}" class="max-w-full h-auto rounded" />
        </div>
    @endif
    <div>
        @if(!empty($data['title']))
            <h3 class="text-xl font-semibold mb-2">
                @if(!empty($data['url']))<a href="{{ $data['url'] }}" class="hover:underline">@endif
                {{ $data['title'] }}
                @if(!empty($data['url']))</a>@endif
            </h3>
        @endif
        @if(!empty($data['content']))
            <div class="prose max-w-none text-gray-600">
                {!! $data['content'] !!}
            </div>
        @endif
    </div>
</div>
