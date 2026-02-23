<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-number-counter {{ $data['class'] ?? '' }}">
    <div class="layup-counter-value">
        <span>{{ $data['prefix'] ?? '' }}</span>
        <span @if($data['animate'] ?? true) x-data="{ count: 0, target: {{ (int)($data['number'] ?? 0) }} }" x-intersect.once="let i = setInterval(() => { count += Math.ceil(target/40); if(count >= target){ count = target; clearInterval(i); } }, 30)" x-text="count" @else x-text="{{ (int)($data['number'] ?? 0) }}" @endif>0</span>
        <span>{{ $data['suffix'] ?? '' }}</span>
    </div>
    @if(!empty($data['title']))
        <div class="layup-counter-title">{{ $data['title'] }}</div>
    @endif
</div>
