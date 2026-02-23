<a href="{{ $data['url'] ?? '#' }}"
   @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
   class="layup-widget-button layup-button-{{ $data['style'] ?? 'primary' }} layup-button-{{ $data['size'] ?? 'md' }} {{ $data['class'] ?? '' }}"
   @if(!empty($data['new_tab'])) target="_blank" rel="noopener noreferrer" @endif>
    {{ $data['label'] ?? 'Click Me' }}
</a>
