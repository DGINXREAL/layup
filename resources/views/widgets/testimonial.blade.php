<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-testimonial layup-testimonial-{{ $data['style'] ?? 'default' }} {{ $data['class'] ?? '' }}">
    @if(!empty($data['quote']))
        <blockquote class="layup-testimonial-quote">{{ $data['quote'] }}</blockquote>
    @endif
    <div class="layup-testimonial-author">
        @if(!empty($data['photo']))
            <img src="{{ asset('storage/' . $data['photo']) }}" alt="{{ $data['author'] ?? '' }}" class="layup-testimonial-photo" />
        @endif
        <div>
            @if(!empty($data['author']))
                <strong>{{ $data['author'] }}</strong>
            @endif
            @if(!empty($data['role']))
                <span>{{ $data['role'] }}</span>
            @endif
        </div>
    </div>
</div>
