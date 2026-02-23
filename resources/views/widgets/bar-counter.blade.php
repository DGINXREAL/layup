<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-bar-counter {{ $data['class'] ?? '' }}">
    @foreach(($data['bars'] ?? []) as $bar)
        <div class="layup-bar-item" @if($data['animate'] ?? true) x-data="{ width: 0 }" x-intersect.once="setTimeout(() => width = {{ (int)($bar['percent'] ?? 0) }}, 100)" @endif>
            <div class="layup-bar-header">
                <span>{{ $bar['label'] ?? '' }}</span>
                @if($data['show_percent'] ?? true)<span @if($data['animate'] ?? true) x-text="width + '%'" @else>{{ $bar['percent'] ?? 0 }}%@endif</span>@endif
            </div>
            <div class="layup-bar-track">
                <div class="layup-bar-fill" @if($data['animate'] ?? true) :style="'width:' + width + '%;'" @else style="width:{{ $bar['percent'] ?? 0 }}%;" @endif @if(!empty($bar['color'])) style="background:{{ $bar['color'] }}" @endif></div>
            </div>
        </div>
    @endforeach
</div>
