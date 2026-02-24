@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $sizeClass = match($data['size'] ?? 'md') {
        'sm' => 'py-1.5 px-3 text-sm',
        'lg' => 'py-3 px-5 text-lg',
        default => 'py-2 px-4 text-base',
    };
@endphp
<form action="{{ $data['action'] ?? '/search' }}" method="GET"
      @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
      class="flex {{ $vis }} {{ $data['class'] ?? '' }}"
      style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
      {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    <input type="search" name="{{ $data['param'] ?? 'q' }}"
           placeholder="{{ $data['placeholder'] ?? 'Search...' }}"
           class="flex-1 border border-gray-300 rounded-l-lg {{ $sizeClass }} focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
    <button type="submit" class="bg-blue-600 text-white rounded-r-lg {{ $sizeClass }} hover:bg-blue-700 transition-colors px-4">
        🔍
    </button>
</form>
