<a href="{{ $data['url'] ?? '#' }}"
   class="layup-widget-button layup-button-{{ $data['style'] ?? 'primary' }} layup-button-{{ $data['size'] ?? 'md' }}"
   @if(!empty($data['new_tab'])) target="_blank" rel="noopener noreferrer" @endif>
    {{ $data['label'] ?? 'Click Me' }}
</a>
