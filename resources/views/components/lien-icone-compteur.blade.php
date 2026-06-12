<a href="{{ $destination }}"
   class="flex items-center gap-1 hover:text-[#E8490F] transition-colors group"
   title="{{ $title }}">

    {{ $slot }}
    
    @if($count !== null)
        <span class="font-semibold text-[#E8490F]">
            {{ $count}}
        </span>
    @endif
    
    
</a>