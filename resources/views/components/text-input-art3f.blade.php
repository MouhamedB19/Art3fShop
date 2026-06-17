@props([
    'value' => "",
    'message' => "",
    'type' => "text",
    'name' => "",
])
<input type={{ $type }} name={{ $name }} value="{{ $value }}"
                               class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                               placeholder="{{ $message }}" required>                                                                                