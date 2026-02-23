<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-toggle {{ $data['class'] ?? '' }}" x-data="{ open: {{ !empty($data['open']) ? 'true' : 'false' }} }">
    <button @click="open = !open" class="layup-toggle-trigger" :class="{ 'active': open }">
        <span>{{ $data['title'] ?? '' }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;transition:transform 0.2s" :style="open ? 'transform:rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
    </button>
    <div x-show="open" x-collapse class="layup-toggle-content">
        {!! $data['content'] ?? '' !!}
    </div>
</div>
