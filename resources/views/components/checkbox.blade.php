@props([
    'model',
    'value' => 1,
    'nameBase' => '',
    'field' => '',
    'idPrefix' => '',
    'class' => '',
])

<input
    type="checkbox"
    :name="'{{ $nameBase }}[' + index + '][{{ $field }}]'"
    :id="'{{ $idPrefix }}_' + index"
    x-model="{{ $model }}"
    value="{{ $value }}"
    class="w-4 h-4 rounded border-gray-300 accent-[#E8490F] {{ $class }}"
>