<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="layup-widget-divider {{ $data['class'] ?? '' }}" style="padding: {{ $data['spacing'] ?? '1rem' }} 0; display: flex; justify-content: center;">
    <hr style="width: {{ $data['width'] ?? '100%' }}; border: none; border-top: {{ $data['weight'] ?? '1px' }} {{ $data['style'] ?? 'solid' }} {{ $data['color'] ?? '#e5e7eb' }};" />
</div>
