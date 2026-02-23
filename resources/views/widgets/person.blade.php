<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-person {{ $data['class'] ?? '' }}">
    @if(!empty($data['photo']))
        <img src="{{ asset('storage/' . $data['photo']) }}" alt="{{ $data['name'] ?? '' }}" class="layup-person-photo" />
    @endif
    @if(!empty($data['name']))
        <h3 class="layup-person-name">{{ $data['name'] }}</h3>
    @endif
    @if(!empty($data['role']))
        <p class="layup-person-role">{{ $data['role'] }}</p>
    @endif
    @if(!empty($data['bio']))
        <div class="layup-person-bio">{!! $data['bio'] !!}</div>
    @endif
    @php $socials = array_filter([$data['facebook'] ?? '', $data['twitter'] ?? '', $data['linkedin'] ?? '', $data['email'] ?? '', $data['website'] ?? '']); @endphp
    @if(count($socials))
        <div class="layup-person-social">
            @if(!empty($data['facebook']))<a href="{{ $data['facebook'] }}" target="_blank" rel="noopener">Facebook</a>@endif
            @if(!empty($data['twitter']))<a href="{{ $data['twitter'] }}" target="_blank" rel="noopener">Twitter</a>@endif
            @if(!empty($data['linkedin']))<a href="{{ $data['linkedin'] }}" target="_blank" rel="noopener">LinkedIn</a>@endif
            @if(!empty($data['email']))<a href="mailto:{{ $data['email'] }}">Email</a>@endif
            @if(!empty($data['website']))<a href="{{ $data['website'] }}" target="_blank" rel="noopener">Website</a>@endif
        </div>
    @endif
</div>
