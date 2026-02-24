<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="flex justify-center {{ $data['class'] ?? '' }}" style="padding: {{ $data['spacing'] ?? '1rem' }} 0;@if(!empty($data['inline_css'])){{ $data['inline_css'] }}@endif">
    <hr class="border-0" style="width: {{ $data['width'] ?? '100%' }}; border-top: {{ $data['weight'] ?? '1px' }} {{ $data['style'] ?? 'solid' }} {{ $data['color'] ?? '#e5e7eb' }};" />
</div>
