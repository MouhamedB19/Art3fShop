@extends('layouts.app')

@section('content')
    <div x-data="{ estCadeau: false }" class="border-t border-gray-100 pt-4 mb-4">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" x-model="estCadeau" name="est_cadeau" class="rounded text-[#E8490F]">
            C'est un cadeau ?
        </label>
    
        <div x-show="estCadeau" x-transition class="mt-2">
            <textarea name="message_cadeau" maxlength="300" rows="3"
                placeholder="Ton message..."
                class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-[#E8490F]"></textarea>
        </div>
    </div>
@endsection