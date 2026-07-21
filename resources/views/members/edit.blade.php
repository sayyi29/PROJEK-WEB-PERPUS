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
                <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">Edit Anggota</h2>
                <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Pembaruan Data Anggota Perpustakaan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6">
            <div class="space-y-10">
                <div class="px-6">
                    <h3 class="text-2xl font-black text-[#062C2C] tracking-tight uppercase tracking-widest">Detail Anggota</h3>
                    <p class="text-[#B8860B] font-bold text-xs uppercase tracking-[0.2em] mt-2">ID Anggota: #{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>

                <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')
                    <div class="premium-card p-12 relative overflow-hidden group">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#B8860B]/5 rounded-full blur-[80px]"></div>
                        
                        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 font-medium text-lg placeholder:text-slate-300"
                                    placeholder="Masukkan nama lengkap...">
                                @error('name') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', $member->email) }}" required
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 placeholder:text-slate-300"
                                    placeholder="contoh@mail.com">
                                @error('email') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 placeholder:text-slate-300"
                                    placeholder="0812xxxxxxxx">
                                @error('phone') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Alamat Lengkap</label>
                                <textarea name="address" rows="3"
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 placeholder:text-slate-300"
                                    placeholder="Masukkan alamat domisili saat ini...">{{ old('address', $member->address) }}</textarea>
                                @error('address') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Foto Profil (Opsional)</label>
                                <input type="file" name="profile_photo"
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 placeholder:text-slate-300 appearance-none">
                                @error('profile_photo') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                
                                @if ($member->profile_photo_path)
                                    <div class="mt-4">
                                        <p class="text-[9px] text-slate-400 ml-2 italic">Foto saat ini:</p>
                                        <img src="{{ asset('storage/' . $member->profile_photo_path) }}" alt="Current profile photo" class="w-24 h-24 object-cover rounded-xl border border-[#E8E4D9] shadow-sm">
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Status Anggota</label>
                                <select name="status" required
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300 placeholder:text-slate-300 appearance-none">
                                    <option value="active" {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $member->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="pending_approval" {{ old('status', $member->status) === 'pending_approval' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                </select>
                                @error('status') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password Baru (Opsional)</label>
                                <input type="password" name="password"
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300">
                                <p class="text-[9px] text-slate-400 mt-2 ml-2 italic">Kosongkan jika tidak ingin mengubah password</p>
                                @error('password') <p class="text-rose-500 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full bg-[#F9F7F2] border border-[#E8E4D9] rounded-3xl px-8 py-5 text-[#062C2C] focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-6 px-6">
                        <button type="submit" class="w-full py-6 bg-[#062C2C] text-white font-black text-xs uppercase tracking-[0.4em] rounded-[2rem] shadow-xl active:scale-95 transition-all hover:bg-[#041E1E] hover:-translate-y-1">
                            Update Data Anggota
                        </button>
                        
                        <a href="{{ route('members.index') }}" class="block w-full py-4 bg-white text-slate-400 border border-[#E8E4D9] font-black text-center text-[10px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-slate-50 hover:text-[#062C2C] hover:border-[#B8860B] transition-all">
                            Batalkan Perubahan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
