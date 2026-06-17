<a href={{ $destination }}
   class="group border border-gray-200 rounded-2xl p-6 hover:border-[#E8490F] hover:shadow-md transition-all">
    <div class="flex items-center gap-4">
        <div class="bg-orange-50 group-hover:bg-orange-100 rounded-xl p-3 transition-colors">
            {{ $slot }}
        </div>
        <div>
            <p class="font-medium text-[#1A1A1A]">{{ $label }}</p>
            <p class="text-sm text-gray-500">{{ $sublabel }}</p>
        </div>
    </div>
</a>