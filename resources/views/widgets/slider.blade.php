<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-slider {{ $data['class'] ?? '' }}" x-data="{ active: 0, total: {{ count($data['slides'] ?? []) }}, autoplay: {{ ($data['autoplay'] ?? true) ? 'true' : 'false' }}, speed: {{ $data['speed'] ?? 5000 }}, timer: null }" x-init="if(autoplay && total > 1) timer = setInterval(() => active = (active + 1) % total, speed)">
    <div class="layup-slider-track" style="position:relative;overflow:hidden">
        @foreach(($data['slides'] ?? []) as $index => $slide)
            <div x-show="active === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="layup-slide" @if(!empty($slide['image'])) style="background-image:url('{{ asset('storage/' . $slide['image']) }}');background-size:cover;background-position:center" @endif>
                <div class="layup-slide-content">
                    @if(!empty($slide['heading']))<h2>{{ $slide['heading'] }}</h2>@endif
                    @if(!empty($slide['content']))<div>{!! $slide['content'] !!}</div>@endif
                    @if(!empty($slide['button_text']))<a href="{{ $slide['button_url'] ?? '#' }}" class="layup-slide-btn">{{ $slide['button_text'] }}</a>@endif
                </div>
            </div>
        @endforeach
    </div>
    @if($data['arrows'] ?? true)
        <button @click="active = (active - 1 + total) % total" class="layup-slider-arrow layup-slider-prev">‹</button>
        <button @click="active = (active + 1) % total" class="layup-slider-arrow layup-slider-next">›</button>
    @endif
    @if($data['dots'] ?? true)
        <div class="layup-slider-dots">
            @foreach(($data['slides'] ?? []) as $index => $slide)
                <button @click="active = {{ $index }}" :class="{ 'active': active === {{ $index }} }" class="layup-slider-dot"></button>
            @endforeach
        </div>
    @endif
</div>
