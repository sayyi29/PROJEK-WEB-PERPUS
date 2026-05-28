<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('categories.index') }}" 
               class="p-4 bg-white/5 rounded-[1.5rem] hover:bg-white/10 transition-all duration-300 text-indigo-400 border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase leading-none mb-1">Tambah Kategori</h2>
                <p class="text-indigo-400 font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Manajemen Klasifikasi Koleksi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div class="space-y-10">
                <div class="px-6">
                    <h3 class="text-2xl font-black text-white tracking-tight uppercase tracking-widest">Informasi Klasifikasi</h3>
                    <p class="text-indigo-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Definisikan kategori baru untuk mengorganisir koleksi buku</p>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <div class="glass-card p-12 rounded-[3.5rem] border border-white/10 shadow-[0_50px_100px_rgba(0,0,0,0.4)] relative overflow-hidden group">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px]"></div>
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-[80px]"></div>
                        
                        <div class="relative space-y-8">
                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">Nama Kategori</label>
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 font-medium text-lg placeholder:text-white/10"
                                    placeholder="Contoh: Sains Fiksi, Sejarah, dsb...">
                                @error('name') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">Lokasi Rak</label>
                                <input type="text" name="rack" value="{{ old('rack') }}" required
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 font-medium text-lg placeholder:text-white/10"
                                    placeholder="Contoh: RAK-A1, LANTAI-2, dsb...">
                                @error('rack') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-8 px-6">
                        <button type="submit" class="w-full py-7 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl active:scale-95 transition-all hover:bg-indigo-500 hover:shadow-indigo-500/20">
                            Simpan Kategori
                        </button>
                        
                        <a href="{{ route('categories.index') }}" class="block w-full py-6 bg-white/5 text-white/40 font-black text-center text-[10px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-white/10 hover:text-white transition-all">
                            Batalkan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</x-app-layout>
