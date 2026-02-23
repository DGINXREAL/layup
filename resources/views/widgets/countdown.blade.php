<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-countdown {{ $data['class'] ?? '' }}" x-data="layupCountdown('{{ $data['target_date'] ?? '' }}')" x-init="start()">
    @if(!empty($data['title']))
        <div class="layup-countdown-title">{{ $data['title'] }}</div>
    @endif
    <div class="layup-countdown-timer" x-show="!expired">
        @if($data['show_days'] ?? true)<div class="layup-countdown-unit"><span x-text="days">0</span><small>Days</small></div>@endif
        @if($data['show_hours'] ?? true)<div class="layup-countdown-unit"><span x-text="hours">0</span><small>Hours</small></div>@endif
        @if($data['show_minutes'] ?? true)<div class="layup-countdown-unit"><span x-text="minutes">0</span><small>Min</small></div>@endif
        @if($data['show_seconds'] ?? true)<div class="layup-countdown-unit"><span x-text="seconds">0</span><small>Sec</small></div>@endif
    </div>
    <div x-show="expired" class="layup-countdown-expired">{{ $data['expired_message'] ?? 'Time is up!' }}</div>
</div>
