<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-map {{ $data['class'] ?? '' }}" style="height:{{ $data['height'] ?? '300px' }}">
    @if(!empty($data['embed']))
        {!! $data['embed'] !!}
    @elseif(!empty($data['address']))
        <iframe
            src="https://maps.google.com/maps?q={{ urlencode($data['address']) }}&z={{ $data['zoom'] ?? '13' }}&output=embed"
            style="width:100%;height:100%;border:0"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    @endif
</div>
