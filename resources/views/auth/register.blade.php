<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-black tracking-tighter text-white">@lang('messages.register')</h2>
        <p class="text-indigo-300/60 font-medium mt-2">@lang('messages.register_message')</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-black uppercase tracking-[0.2em] text-indigo-300 mb-2">@lang('messages.full_name')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-500 group-focus-within:text-indigo-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" 
                       name="name" 
                       type="text" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="@lang('messages.full_name')"
                       class="block w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 text-white placeholder:text-white/20 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 outline-none">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-[0.2em] text-indigo-300 mb-2">@lang('messages.email_address')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-500 group-focus-within:text-indigo-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email" 
                       name="email" 
                       type="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="username"
                       placeholder="{{ __('messages.enter_email') }}"
                       class="block w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 text-white placeholder:text-white/20 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 outline-none">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-[0.2em] text-indigo-300 mb-2">@lang('messages.password')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-500 group-focus-within:text-indigo-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" 
                       name="password" 
                       type="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="••••••••"
                       class="block w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 text-white placeholder:text-white/20 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 outline-none">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-black uppercase tracking-[0.2em] text-indigo-300 mb-2">@lang('messages.confirm_password')</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-500 group-focus-within:text-indigo-400 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="••••••••"
                       class="block w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 text-white placeholder:text-white/20 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 outline-none">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit" 
                    class="w-full flex justify-center py-4 px-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-indigo-600/30 hover:bg-indigo-500 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                @lang('messages.join_community')
            </button>
        </div>
    </form>

    <div class="mt-8 pt-8 border-t border-white/5 text-center">
        <p class="text-xs font-bold text-indigo-100/30 uppercase tracking-widest">
            @lang('messages.already_member') 
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-white transition-colors ml-2">@lang('messages.sign_in')</a>
        </p>
    </div>
</x-guest-layout>
