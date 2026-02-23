<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-pricing {{ !empty($data['featured']) ? 'layup-pricing-featured' : '' }} {{ $data['class'] ?? '' }}">
    @if(!empty($data['title']))
        <h3 class="layup-pricing-title">{{ $data['title'] }}</h3>
    @endif
    @if(!empty($data['subtitle']))
        <p class="layup-pricing-subtitle">{{ $data['subtitle'] }}</p>
    @endif
    <div class="layup-pricing-price">
        <span class="layup-pricing-currency">{{ $data['currency'] ?? '$' }}</span>
        <span class="layup-pricing-amount">{{ $data['price'] ?? '' }}</span>
        @php
            $period = match($data['period'] ?? 'month') {
                'month' => '/mo',
                'year' => '/yr',
                'once' => '',
                'custom' => $data['period_custom'] ?? '',
                default => '',
            };
        @endphp
        @if($period)<span class="layup-pricing-period">{{ $period }}</span>@endif
    </div>
    @if(!empty($data['features']))
        <ul class="layup-pricing-features">
            @foreach($data['features'] as $feature)
                <li class="{{ ($feature['included'] ?? true) ? '' : 'layup-pricing-excluded' }}">{{ $feature['text'] ?? '' }}</li>
            @endforeach
        </ul>
    @endif
    @if(!empty($data['button_text']))
        <a href="{{ $data['button_url'] ?? '#' }}" class="layup-pricing-button">{{ $data['button_text'] }}</a>
    @endif
</div>
