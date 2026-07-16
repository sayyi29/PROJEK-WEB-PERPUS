<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center lg:text-left reveal-up stagger-1">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#B8860B]/10 border border-[#B8860B]/20 mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-[#B8860B] animate-pulse"></span>
            <span class="text-[9px] font-black text-[#B8860B] uppercase tracking-widest">New Member Registration</span>
        </div>
        <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] leading-none">@lang('messages.register')</h2>
        <p class="text-[#062C2C]/50 font-medium mt-3 text-sm">@lang('messages.register_message')</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 reveal-up stagger-2">
        @csrf

        {{-- Full Name --}}
        <div>
            <label for="name" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.full_name')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name"
                       name="name"
                       type="text"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="name"
                       placeholder="{{ __('messages.full_name') }}"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 ml-4" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.email_address')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="username"
                       placeholder="{{ __('messages.enter_email') }}"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        {{-- Phone & Address in 2-column grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.phone')</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <input id="phone"
                           name="phone"
                           type="tel"
                           value="{{ old('phone') }}"
                           placeholder="08xxxxxxxxxx"
                           class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2 ml-4" />
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.address')</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <input id="address"
                           name="address"
                           type="text"
                           value="{{ old('address') }}"
                           placeholder="Jl. Sudirman No. 12"
                           class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
                </div>
                <x-input-error :messages="$errors->get('address')" class="mt-2 ml-4" />
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.password')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password"
                       name="password"
                       type="password"
                       required
                       autocomplete="new-password"
                       placeholder="••••••••"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B] mb-2 ml-1">@lang('messages.confirm_password')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-[#062C2C]/20 group-focus-within:text-[#B8860B] transition-all duration-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       required
                       autocomplete="new-password"
                       placeholder="••••••••"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-4 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/10 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-4" />
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                    class="group relative w-full overflow-hidden rounded-[2rem] bg-[#062C2C] py-5 text-white shadow-2xl transition-all duration-500 hover:scale-[1.02] active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B8860B] to-[#DAA520] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                <span class="relative text-[11px] font-black uppercase tracking-[0.3em]">@lang('messages.join_community')</span>
            </button>
        </div>
    </form>

    {{-- Footer Link --}}
    <div class="mt-8 pt-8 border-t border-[#E8E4D9] text-center reveal-up stagger-3">
        <p class="text-[10px] font-bold text-[#062C2C]/30 uppercase tracking-widest">
            @lang('messages.already_member')
            <a href="{{ route('login') }}" class="text-[#062C2C] font-black hover:text-[#B8860B] transition-all duration-300 ml-2 border-b-2 border-[#062C2C]/10 hover:border-[#B8860B]">@lang('messages.sign_in_to_library')</a>
        </p>
    </div>
</x-guest-layout>
