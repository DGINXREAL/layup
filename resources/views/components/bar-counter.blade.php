<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="space-y-3 {{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @foreach(($data['bars'] ?? []) as $bar)
        <div x-data="layupBarCounter({{ (int)($bar['percent'] ?? 0) }}, {{ ($data['animate'] ?? true) ? 'true' : 'false' }})" x-intersect.once="start()">
            <div class="flex justify-between text-sm mb-1">
                <span class="font-medium">{{ $bar['label'] ?? '' }}</span>
                @if($data['show_percent'] ?? true)
                    <span class="text-gray-500">{{ $bar['percent'] ?? 0 }}%</span>
                @endif
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-1000 ease-out"
                     :style="'width: ' + width + '%; background-color: {{ $bar['color'] ?? '#3b82f6' }}'"
                ></div>
            </div>
        </div>
    @endforeach
</div>
