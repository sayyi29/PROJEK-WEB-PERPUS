<div>
    <button wire:click="toggle" 
            class="p-4 rounded-[1.5rem] transition-all duration-300 border shadow-xl hover:scale-110 active:scale-95 group {{ $isWishlisted ? 'bg-pink-500/20 text-pink-500 border-pink-500/20' : 'bg-white/5 text-white/30 border-white/5 hover:bg-white/10' }}">
        <svg class="w-6 h-6 {{ $isWishlisted ? 'fill-current' : 'none' }}" fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
</div>
