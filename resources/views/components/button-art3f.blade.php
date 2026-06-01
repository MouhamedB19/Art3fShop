<button type="submit" :disabled="loading" class="px-5 py-2.5 bg-[#E8490F] hover:bg-orange-600 text-white text-sm        font-bold rounded-lg transition-colors disabled:opacity-60 shrink-0        flex items-center gap-2">
    <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
    </svg>
    <span x-show="!loading">{{ $label }}</span>
    <span x-show="loading">...</span>
</button>