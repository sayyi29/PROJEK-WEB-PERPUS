<div class="space-y-10">
    <!-- ISBN Fetch Section -->
    <div class="glass-card p-10 rounded-[3rem] border border-white/10 shadow-2xl relative overflow-hidden group">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-[80px]"></div>
        
        <div class="relative flex flex-col md:flex-row items-end gap-6">
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4">Auto-fill via ISBN</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/20 group-focus-within:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 4h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    </div>
                    <input type="text" 
                           wire:model="isbn"
                           class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 text-white placeholder:text-white/10 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                           placeholder="Masukkan 10 atau 13 digit ISBN...">
                </div>
            </div>
            <button wire:click="fetchBookData" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-indigo-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 disabled:opacity-50">
                <span wire:loading.remove wire:target="fetchBookData">Ambil Data</span>
                <span wire:loading wire:target="fetchBookData">Mengambil...</span>
            </button>
        </div>
    </div>

    <!-- Book Form Section -->
    <form wire:submit.prevent="save" class="glass-card p-12 rounded-[3.5rem] border border-white/10 shadow-2xl relative overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Title -->
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Judul Koleksi</label>
                <input type="text" wire:model="title" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('title') <span class="text-red-400 text-[10px] mt-1 uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Author -->
            <div>
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Penulis</label>
                <input type="text" wire:model="author" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('author') <span class="text-red-400 text-[10px] mt-1 uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Kategori</label>
                <select wire:model="category_id" class="w-full bg-slate-900 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Pilih Kategori...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-400 text-[10px] mt-1 uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Publisher & Year -->
            <div>
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Penerbit</label>
                <input type="text" wire:model="publisher" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Tahun</label>
                    <input type="number" wire:model="year" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Stok</label>
                    <input type="number" wire:model="stock" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">Deskripsi / Sinopsis</label>
                <textarea wire:model="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-[2rem] py-4 px-6 text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
            </div>

            <!-- Cover Preview -->
            @if($cover_image)
            <div class="md:col-span-2 flex items-center gap-6 p-6 bg-indigo-500/5 rounded-[2rem] border border-indigo-500/10">
                <img src="{{ $cover_image }}" class="w-20 h-28 object-cover rounded-xl shadow-2xl">
                <div>
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Preview Sampul</p>
                    <p class="text-xs text-white/40">Sampul ditemukan di Google Books. Akan otomatis di-download ke server saat disimpan.</p>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-12 flex justify-end gap-4 border-t border-white/5 pt-10">
            <a href="{{ route('books.index') }}" class="px-10 py-4 bg-white/5 text-white/40 font-black text-[10px] uppercase tracking-[0.2em] rounded-xl hover:bg-white/10 transition-all">Batal</a>
            <button type="submit" class="px-12 py-4 bg-green-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-xl hover:bg-green-500 transition-all shadow-xl shadow-green-600/20 active:scale-95">
                Simpan Koleksi
            </button>
        </div>
    </form>
</div>
