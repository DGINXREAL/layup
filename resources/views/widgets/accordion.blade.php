<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-accordion {{ $data['class'] ?? '' }}" x-data="{ active: {{ !empty($data['open_first']) ? '0' : 'null' }} }">
    @foreach(($data['items'] ?? []) as $index => $item)
        <div class="layup-accordion-item">
            <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="layup-accordion-trigger" :class="{ 'active': active === {{ $index }} }">
                <span>{{ $item['title'] ?? '' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;transition:transform 0.2s" :style="active === {{ $index }} ? 'transform:rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </button>
            <div x-show="active === {{ $index }}" x-collapse class="layup-accordion-content">
                {!! $item['content'] ?? '' !!}
            </div>
        </div>
    @endforeach
</div>
