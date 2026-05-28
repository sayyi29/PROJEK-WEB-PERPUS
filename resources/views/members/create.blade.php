<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('members.index') }}" 
               class="p-4 bg-white/5 rounded-[1.5rem] hover:bg-white/10 transition-all duration-300 text-indigo-400 border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase leading-none mb-1">@lang('messages.member_registration_header')</h2>
                <p class="text-indigo-400 font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">@lang('messages.member_registration_system')</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6">
            <div class="space-y-10">
                <div class="px-6">
                    <h3 class="text-2xl font-black text-white tracking-tight uppercase tracking-widest">@lang('messages.personal_information')</h3>
                    <p class="text-indigo-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">@lang('messages.complete_personal_data')</p>
                </div>

                <form action="{{ route('members.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <div class="glass-card p-12 rounded-[3.5rem] border border-white/10 shadow-[0_50px_100px_rgba(0,0,0,0.4)] relative overflow-hidden group">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px]"></div>
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-[80px]"></div>
                        
                        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.full_name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 font-medium text-lg placeholder:text-white/10"
                                    placeholder="@lang('messages.enter_full_name_placeholder')">
                                @error('name') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.email_address')</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 placeholder:text-white/10"
                                    placeholder="@lang('messages.email_placeholder')">
                                @error('email') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.phone')</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 placeholder:text-white/10"
                                    placeholder="@lang('messages.phone_placeholder')">
                                @error('phone') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.address')</label>
                                <textarea name="address" rows="3"
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 placeholder:text-white/10"
                                    placeholder="@lang('messages.enter_address_placeholder')">{{ old('address') }}</textarea>
                                @error('address') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.profile_photo')</label>
                                <input type="file" name="profile_photo"
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 placeholder:text-white/10 appearance-none">
                                @error('profile_photo') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.password_login')</label>
                                <input type="password" name="password" required
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                                @error('password') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.confirm_password')</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-8 px-6">
                        <button type="submit" class="w-full py-7 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl active:scale-95 transition-all hover:bg-indigo-500 hover:shadow-indigo-500/20">
                            @lang('messages.register_member_button')
                        </button>
                        
                        <a href="{{ route('members.index') }}" class="block w-full py-6 bg-white/5 text-white/40 font-black text-center text-[10px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-white/10 hover:text-white transition-all">
                            @lang('messages.cancel_registration')
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
