<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="text-center {{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" x-data="layupCountdown('{{ $data['target_date'] ?? '' }}')" x-init="start()" style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}">
    @if(!empty($data['title']))
        <div class="text-lg font-semibold mb-4">{{ $data['title'] }}</div>
    @endif
    <div class="flex justify-center gap-4" x-show="!expired">
        @if($data['show_days'] ?? true)
            <div class="flex flex-col items-center">
                <span class="text-3xl font-bold" x-text="days">0</span>
                <span class="text-xs text-gray-500 uppercase">Days</span>
            </div>
        @endif
        @if($data['show_hours'] ?? true)
            <div class="flex flex-col items-center">
                <span class="text-3xl font-bold" x-text="hours">0</span>
                <span class="text-xs text-gray-500 uppercase">Hours</span>
            </div>
        @endif
        @if($data['show_minutes'] ?? true)
            <div class="flex flex-col items-center">
                <span class="text-3xl font-bold" x-text="minutes">0</span>
                <span class="text-xs text-gray-500 uppercase">Min</span>
            </div>
        @endif
        @if($data['show_seconds'] ?? true)
            <div class="flex flex-col items-center">
                <span class="text-3xl font-bold" x-text="seconds">0</span>
                <span class="text-xs text-gray-500 uppercase">Sec</span>
            </div>
        @endif
    </div>
    <div x-show="expired" class="text-xl font-semibold text-green-600">
        {{ $data['expired_message'] ?? 'Time is up!' }}
    </div>
</div>
