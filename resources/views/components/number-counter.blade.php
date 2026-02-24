<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="text-center {{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    <div class="text-4xl font-bold mb-1">
        <span>{{ $data['prefix'] ?? '' }}</span>
        <span x-data="layupCounter({{ (int)($data['number'] ?? 0) }}, {{ ($data['animate'] ?? true) ? 'true' : 'false' }})" x-intersect.once="start()" x-text="count">0</span>
        <span>{{ $data['suffix'] ?? '' }}</span>
    </div>
    @if(!empty($data['title']))
        <div class="text-sm text-gray-500 uppercase tracking-wide">{{ $data['title'] }}</div>
    @endif
</div>
