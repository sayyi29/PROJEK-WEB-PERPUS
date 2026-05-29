<div x-data="{ open: false }" class="relative w-full">
    <!-- Compact Minimalist Search Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-1 flex items-center gap-2 transition-all focus-within:shadow-md focus-within:border-[#B8860B] w-full max-w-sm">
        
        <!-- Icon & Input -->
        <div class="flex-1 relative flex items-center group">
            <div class="pl-4 text-slate-300 group-focus-within:text-[#B8860B] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" 
                   wire:model.live.debounce.300ms="query"
                   @focus="open = true"
                   class="w-full bg-transparent border-0 py-2 pl-3 pr-4 text-xs text-[#062C2C] placeholder-slate-300 font-bold focus:ring-0" 
                   placeholder="Search assets...">
        </div>

        <!-- Mini Execute Button -->
        <button wire:click="search" class="bg-[#062C2C] hover:bg-[#041E1E] text-white p-2 rounded-xl transition-all active:scale-90 shadow-lg">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </button>
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="open && $wire.query.length > 2" 
         @click.away="open = false"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="absolute top-full left-0 right-0 mt-6 bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(6,44,44,0.1)] border border-[#E8E4D9] overflow-hidden z-[100]">
        
        <div class="max-h-[500px] overflow-y-auto p-10 custom-scrollbar bg-[#FDFCF9]/50">
            @if(count($results) > 0)
                <div class="grid grid-cols-1 gap-6">
                    @foreach($results as $book)
                        @php
                            $info = $book['volumeInfo'] ?? [];
                            $title = $info['title'] ?? 'No Title';
                            $authors = implode(', ', $info['authors'] ?? ['Unknown Author']);
                            $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? 'https://via.placeholder.com/150x200?text=No+Cover');
                        @endphp
                        <a href="{{ $info['infoLink'] ?? '#' }}" target="_blank" class="flex items-center gap-8 p-5 rounded-[2rem] hover:bg-white hover:shadow-xl hover:shadow-[#062C2C]/5 transition-all group border border-transparent hover:border-[#E8E4D9]">
                            <div class="w-20 h-28 bg-white rounded-2xl overflow-hidden shadow-lg flex-shrink-0 border border-[#E8E4D9] group-hover:scale-105 transition-transform">
                                <img src="{{ str_replace('http://', 'https://', $cover) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-[9px] font-black text-[#B8860B] uppercase tracking-widest mb-1">Asset Authenticated</p>
                                <h4 class="text-lg font-black text-[#062C2C] truncate tracking-tight uppercase leading-tight">{{ $title }}</h4>
                                <p class="text-xs text-slate-400 font-bold mt-1 uppercase tracking-widest">{{ $authors }}</p>
                            </div>
                            <div class="text-[#B8860B] opacity-0 group-hover:opacity-100 group-hover:translate-x-2 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-20 text-center opacity-40">
                    <svg class="w-12 h-12 mx-auto mb-4 text-[#062C2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-[#062C2C]">No assets found for "{{ $query }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>