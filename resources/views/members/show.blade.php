<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('members.index') }}" 
               class="p-4 bg-white rounded-[1.5rem] hover:bg-slate-50 transition-all duration-300 text-[#062C2C] border border-[#E8E4D9] shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">Detail Anggota</h2>
                <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Informasi Lengkap Anggota Perpustakaan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6">
            <div class="space-y-10">
                <div class="px-6 flex justify-between items-end">
                    <div>
                        <h3 class="text-2xl font-black text-[#062C2C] tracking-tight uppercase tracking-widest">Detail Anggota</h3>
                        <p class="text-[#B8860B] font-bold text-xs uppercase tracking-[0.2em] mt-2">ID Anggota: #{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <a href="{{ route('members.edit', $member->id) }}" class="px-6 py-3 bg-[#062C2C] text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl hover:bg-[#041E1E] hover:-translate-y-1 transition-all">
                        Edit Data
                    </a>
                </div>

                <div class="premium-card p-12 relative overflow-hidden group">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#B8860B]/5 rounded-full blur-[80px]"></div>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="md:col-span-2 flex items-center gap-6 mb-4">
                            @if ($member->profile_photo_path)
                                <img src="{{ asset('storage/' . $member->profile_photo_path) }}" alt="Profile photo" class="w-32 h-32 object-cover rounded-[2rem] border-4 border-[#E8E4D9] shadow-xl">
                            @else
                                <div class="w-32 h-32 bg-[#F9F7F2] border-4 border-[#E8E4D9] rounded-[2rem] flex items-center justify-center text-slate-300 shadow-xl">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-3xl font-black text-[#062C2C]">{{ $member->name }}</h4>
                                <p class="text-slate-500 font-bold text-sm tracking-wider mt-1">{{ $member->email }}</p>
                                <div class="mt-4 flex gap-3">
                                    <span class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest
                                        {{ $member->status === 'active' ? 'bg-emerald-100 text-emerald-600' : 
                                        ($member->status === 'inactive' ? 'bg-rose-100 text-rose-600' : 
                                        'bg-amber-100 text-amber-600') }}">
                                        {{ str_replace('_', ' ', $member->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 border-t border-[#E8E4D9] pt-8">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nomor Telepon</label>
                            <p class="text-[#062C2C] font-medium px-4 py-2 bg-[#F9F7F2] rounded-2xl">{{ $member->phone ?? '-' }}</p>
                        </div>
                        
                        <div class="space-y-2 border-t border-[#E8E4D9] pt-8">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Bergabung Sejak</label>
                            <p class="text-[#062C2C] font-medium px-4 py-2 bg-[#F9F7F2] rounded-2xl">{{ $member->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="md:col-span-2 space-y-2 border-t border-[#E8E4D9] pt-8">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Alamat Lengkap</label>
                            <p class="text-[#062C2C] font-medium px-4 py-4 bg-[#F9F7F2] rounded-3xl leading-relaxed">{{ $member->address ?? 'Alamat belum diisi.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
