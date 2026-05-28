<x-guest-layout>
    <div class="mb-10 text-center lg:text-left reveal-up stagger-1">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#B8860B]/10 border border-[#B8860B]/20 mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-[#B8860B] animate-pulse"></span>
            <span class="text-[9px] font-black text-[#B8860B] uppercase tracking-widest">Secure Access Point</span>
        </div>
        <h2 class="text-5xl font-black tracking-tighter text-[#062C2C] leading-none">@lang('messages.sign_in')</h2>
        <p class="text-[#062C2C]/50 font-medium mt-3 text-sm">@lang('messages.welcome_message_login')</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 reveal-up stagger-2" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="reveal-up stagger-2">
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
                       autofocus 
                       autocomplete="username"
                       placeholder="{{ __('messages.enter_email') }}"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-5 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/5 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <!-- Password -->
        <div class="reveal-up stagger-3">
            <div class="flex items-center justify-between mb-2 ml-1">
                <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#B8860B]">@lang('messages.password')</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[9px] font-black uppercase tracking-widest text-[#062C2C]/40 hover:text-[#B8860B] transition-all duration-300">@lang('messages.forgot_password')</a>
                @endif
            </div>
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
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="block w-full bg-white border border-[#E8E4D9] rounded-[2rem] py-5 pl-14 pr-6 text-[#062C2C] font-semibold placeholder:text-[#062C2C]/20 focus:ring-4 focus:ring-[#B8860B]/5 focus:border-[#B8860B] transition-all duration-500 outline-none shadow-sm group-hover:border-[#B8860B]/30">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
        </div>

        <!-- Remember Me & Interactive Button -->
        <div class="space-y-6 reveal-up stagger-4">
            <div class="flex items-center ml-1">
                <input id="remember_me" 
                       name="remember" 
                       type="checkbox" 
                       class="h-4 w-4 rounded-lg border-[#E8E4D9] bg-white text-[#B8860B] focus:ring-[#B8860B] transition-all cursor-pointer">
                <label for="remember_me" class="ml-3 block text-[10px] font-black text-[#062C2C]/40 uppercase tracking-widest cursor-pointer hover:text-[#062C2C] transition-colors">@lang('messages.stay_connected')</label>
            </div>

            <button type="submit" 
                    class="group relative w-full overflow-hidden rounded-[2rem] bg-[#062C2C] py-5 text-white shadow-2xl transition-all duration-500 hover:scale-[1.02] active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B8860B] to-[#DAA520] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                <span class="relative text-[11px] font-black uppercase tracking-[0.3em]">@lang('messages.access_library')</span>
            </button>
        </div>
    </form>

    <div class="mt-12 pt-8 border-t border-[#E8E4D9] text-center reveal-up stagger-5">
        <p class="text-[10px] font-bold text-[#062C2C]/30 uppercase tracking-widest">
            @lang('messages.new_here') 
            <a href="{{ route('register') }}" class="text-[#062C2C] font-black hover:text-[#B8860B] transition-all duration-300 ml-2 border-b-2 border-[#062C2C]/10 hover:border-[#B8860B]">@lang('messages.create_member_account')</a>
        </p>
    </div>
</x-guest-layout>
