<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif class="bg-gray-50 rounded-xl p-8 text-center {{ $data['class'] ?? '' }}" @if(!empty($data['inline_css']))style="{{ $data['inline_css'] }}"@endif>
    @if(!empty($data['title']))
        <h2 class="text-2xl font-bold mb-3">{{ $data['title'] }}</h2>
    @endif
    @if(!empty($data['content']))
        <div class="prose max-w-2xl mx-auto mb-6 text-gray-600">
            {!! $data['content'] !!}
        </div>
    @endif
    @if(!empty($data['button_text']))
        <a href="{{ $data['button_url'] ?? '#' }}" class="inline-block bg-blue-600 text-white font-medium px-6 py-3 rounded hover:bg-blue-700 transition-colors" @if(!empty($data['new_tab'])) target="_blank" rel="noopener noreferrer" @endif>
            {{ $data['button_text'] }}
        </a>
    @endif
</div>
