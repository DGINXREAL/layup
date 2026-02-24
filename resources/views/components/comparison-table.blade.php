@php
    $vis = \Crumbls\Layup\View\BaseView::visibilityClasses($data['hide_on'] ?? []);
    $color = $data['highlight_color'] ?? '#3b82f6';
@endphp
<div @if(!empty($data['id']))id="{{ $data['id'] }}"@endif
     class="overflow-x-auto {{ $vis }} {{ $data['class'] ?? '' }}"
     style="{{ \Crumbls\Layup\View\BaseView::buildInlineStyles($data) }}"
     {!! \Crumbls\Layup\View\BaseView::animationAttributes($data) !!}
>
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr>
                <th class="text-left p-3 border-b-2 border-gray-200">Feature</th>
                <th class="text-center p-3 border-b-2 font-bold" style="border-color: {{ $color }}; color: {{ $color }}">{{ $data['column_a'] ?? 'Us' }}</th>
                <th class="text-center p-3 border-b-2 border-gray-200 text-gray-500">{{ $data['column_b'] ?? 'Them' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach(($data['rows'] ?? []) as $i => $row)
                <tr class="{{ $i % 2 === 0 ? 'bg-gray-50' : '' }}">
                    <td class="p-3 border-b border-gray-100">{{ $row['feature'] ?? '' }}</td>
                    <td class="p-3 border-b border-gray-100 text-center font-medium">{{ $row['value_a'] ?? '' }}</td>
                    <td class="p-3 border-b border-gray-100 text-center text-gray-400">{{ $row['value_b'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
