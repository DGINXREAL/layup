<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-tabs {{ $data['class'] ?? '' }}" x-data="{ active: 0 }">
    <div class="layup-tabs-nav">
        @foreach(($data['tabs'] ?? []) as $index => $tab)
            <button @click="active = {{ $index }}" :class="{ 'active': active === {{ $index }} }" class="layup-tab-btn">{{ $tab['title'] ?? 'Tab' }}</button>
        @endforeach
    </div>
    @foreach(($data['tabs'] ?? []) as $index => $tab)
        <div x-show="active === {{ $index }}" class="layup-tab-content">{!! $tab['content'] ?? '' !!}</div>
    @endforeach
</div>
