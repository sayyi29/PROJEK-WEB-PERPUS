<div class="space-y-8">
    <div class="glass-card p-10 rounded-[3rem] border border-white/10 shadow-2xl relative overflow-hidden group">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-[80px]"></div>
        
        <h3 class="text-2xl font-black text-white mb-6 tracking-tight">Rating & Ulasan</h3>

        @if($hasRated)
            <div class="flex items-center gap-4 mb-6">
                <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $rating ? 'text-yellow-400' : 'text-white/10' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-sm font-black text-indigo-400 uppercase tracking-widest">Ulasan Anda Terkirim</span>
            </div>
            <p class="text-white/60 italic leading-relaxed">"{{ $review }}"</p>
        @else
            <form wire:submit.prevent="submit" class="space-y-6">
                <!-- Stars -->
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em]">Berikan Bintang</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    wire:click="setRating({{ $i }})" 
                                    class="transition-all duration-300 transform hover:scale-125 focus:outline-none">
                                <svg class="w-10 h-10 {{ $i <= $rating ? 'text-yellow-400 drop-shadow-[0_0_10px_rgba(250,204,21,0.5)]' : 'text-white/10 hover:text-white/30' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Review Text -->
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em]">Tulis Ulasan (Opsional)</label>
                    <textarea wire:model="review" 
                              rows="3" 
                              class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white placeholder-white/20 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                              placeholder="Bagaimana pendapat Anda tentang buku ini?"></textarea>
                </div>

                <button type="submit" 
                        class="px-8 py-3 bg-indigo-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-xl hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                    Kirim Ulasan
                </button>
            </form>
        @endif
    </div>

    <!-- Other Reviews List -->
    <div class="space-y-6">
        <h4 class="text-xs font-black text-indigo-400 uppercase tracking-[0.4em] ml-4">Ulasan Pembaca</h4>
        @forelse($book->ratings as $r)
            <div class="glass-card p-8 rounded-3xl border border-white/5 flex gap-6 items-start">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black flex-shrink-0">
                    {{ substr($r->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <h5 class="text-sm font-black text-white uppercase tracking-wider">{{ $r->user->name }}</h5>
                        <div class="flex gap-0.5">
                            @for($j = 1; $j <= 5; $j++)
                                <svg class="w-3 h-3 {{ $j <= $r->rating ? 'text-yellow-400' : 'text-white/10' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-white/40 leading-relaxed">{{ $r->review ?: 'Tidak ada komentar.' }}</p>
                    <p class="text-[9px] text-white/20 mt-4 uppercase font-bold tracking-widest">{{ $r->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-10 opacity-20">
                <p class="text-sm">Belum ada ulasan untuk buku ini.</p>
            </div>
        @endforelse
    </div>
</div>
