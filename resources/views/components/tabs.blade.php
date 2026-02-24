<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="border border-gray-200 rounded-lg {{ \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []) }} {{ $data['class'] ?? '' }}" x-data="layupTabs()" style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}">
    <div class="flex border-b border-gray-200 overflow-x-auto" role="tablist">
        @foreach(($data['tabs'] ?? []) as $index => $tab)
            <button @click="select({{ $index }})" class="px-4 py-2.5 text-sm font-medium whitespace-nowrap transition-colors" :class="isActive({{ $index }}) ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-700'" role="tab">{{ $tab['title'] ?? 'Tab' }}</button>
        @endforeach
    </div>
    @foreach(($data['tabs'] ?? []) as $index => $tab)
        <div x-show="isActive({{ $index }})" class="p-4 text-gray-600" role="tabpanel">
            {!! $tab['content'] ?? '' !!}
        </div>
    @endforeach
</div>
