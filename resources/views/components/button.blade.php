<a href="{{ $data['url'] ?? '#' }}"
   @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
   class="inline-block rounded font-medium transition-colors
       {{ match($data['style'] ?? 'primary') {
           'primary'   => 'bg-blue-600 text-white hover:bg-blue-700',
           'secondary' => 'bg-gray-600 text-white hover:bg-gray-700',
           'outline'   => 'border border-blue-600 text-blue-600 hover:bg-blue-50',
           'ghost'     => 'text-blue-600 hover:bg-blue-50',
           default     => 'bg-blue-600 text-white hover:bg-blue-700',
       } }}
       {{ match($data['size'] ?? 'md') {
           'sm' => 'px-3 py-1.5 text-sm',
           'md' => 'px-5 py-2.5 text-base',
           'lg' => 'px-7 py-3 text-lg',
           default => 'px-5 py-2.5 text-base',
       } }}
       {{ $data['class'] ?? '' }}"
   @if(!empty($data['new_tab'])) target="_blank" rel="noopener noreferrer" @endif
   @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif
>
    {{ $data['label'] ?? 'Click Me' }}
</a>
