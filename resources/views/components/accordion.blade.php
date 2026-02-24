<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="divide-y divide-gray-200 border border-gray-200 rounded-lg {{ $data['class'] ?? '' }}" x-data="{ active: {{ !empty($data['open_first']) ? '0' : 'null' }} }" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @foreach(($data['items'] ?? []) as $index => $item)
        <div>
            <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="flex items-center justify-between w-full px-4 py-3 text-left font-medium hover:bg-gray-50 transition-colors" :class="active === {{ $index }} ? 'bg-gray-50' : ''">
                <span>{{ $item['title'] ?? '' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0 transition-transform duration-200" :class="active === {{ $index }} ? 'rotate-180' : ''"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </button>
            <div x-show="active === {{ $index }}" x-collapse>
                <div class="px-4 py-3 text-gray-600">
                    {!! $item['content'] ?? '' !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
