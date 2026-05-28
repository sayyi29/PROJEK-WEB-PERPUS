<div class="px-8 py-10 flex flex-col h-full bg-[#062C2C] overflow-y-auto custom-scrollbar">
    <!-- Logo -->
    <div class="mb-14 px-4 flex items-center gap-3">
        <div class="w-8 h-8 bg-[#B8860B] rounded-lg flex items-center justify-center text-[#062C2C] font-black shadow-lg shadow-[#B8860B]/20">L</div>
        <h2 class="text-2xl font-black tracking-tighter text-white uppercase">{{ __('messages.the') }}<span class="text-[#B8860B]">.</span></h2>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 space-y-8">
        @if(auth()->user()->hasRole('admin'))
            <!-- ADMIN MENU -->
            <div class="space-y-2">
                <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">{{ __('messages.general_menu') }}</p>
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="discover">
                    {{ __('messages.dashboard') }}
                </x-sidebar-link>
            </div>

            <div class="space-y-2">
                <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">{{ __('messages.master_data') }}</p>
                <x-sidebar-link :href="route('books.index')" :active="request()->routeIs('books.*')" icon="category">
                    {{ __('messages.data_books') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="library">
                    {{ __('messages.categories_racks') }}
                </x-sidebar-link>
                @php
                    $pendingMembers = \App\Models\User::where('status', 'pending')->count();
                @endphp
                <x-sidebar-link :href="route('members.index')" :active="request()->routeIs('members.*')" icon="members" :badge="$pendingMembers > 0 ? $pendingMembers : null" badgeColor="bg-[#B8860B]">
                    {{ __('messages.data_members') }}
                </x-sidebar-link>
            </div>

            <div class="space-y-2">
                <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">{{ __('messages.transaction_circulation') }}</p>
                @php
                    $overdueCount = \App\Models\Borrowing::where('status', 'overdue')->count();
                @endphp
                <x-sidebar-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')" icon="library" :badge="$overdueCount > 0 ? $overdueCount : null" badgeColor="bg-rose-900">
                    {{ __('messages.borrowings') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('returns.index')" :active="request()->routeIs('returns.*')" icon="discover">
                    {{ __('messages.return') }}
                </x-sidebar-link>
            </div>

            <div class="space-y-2">
                <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">{{ __('messages.finance') }} & {{ __('messages.report') }}</p>
                @php
                    $unpaidFines = \App\Models\Fine::where('status', 'unpaid')->count();
                @endphp
                <x-sidebar-link :href="route('fines.index')" :active="request()->routeIs('fines.*')" icon="fines" :badge="$unpaidFines > 0 ? $unpaidFines : null" badgeColor="bg-[#B8860B]">
                    {{ __('messages.fine_history') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" icon="reports">
                    {{ __('messages.print_report_sidebar') }}
                </x-sidebar-link>
            </div>
        @else
            <!-- MEMBER MENU -->
            <div class="space-y-2">
                <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">Personal</p>
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="discover">
                    {{ __('messages.dashboard') }}
                </x-sidebar-link>
                
                @php
                    $activeLoans = \App\Models\Borrowing::where('user_id', auth()->id())->where('status', 'borrowed')->count();
                @endphp
                <x-sidebar-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')" icon="library" :badge="$activeLoans > 0 ? $activeLoans : null" badgeColor="bg-[#B8860B]">
                    My Collection
                </x-sidebar-link>

                <x-sidebar-link :href="route('returns.index')" :active="request()->routeIs('returns.*')" icon="discover">
                    Reading History
                </x-sidebar-link>

                @php
                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                @endphp
                <x-sidebar-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')" icon="category" :badge="$wishlistCount > 0 ? $wishlistCount : null" badgeColor="bg-[#B8860B]">
                    My Wishlist
                </x-sidebar-link>
            </div>
        @endif

        <!-- SHARED SYSTEM MENU -->
        <div class="space-y-2">
            <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-4 px-4">{{ __('messages.system_configuration') }}</p>
            <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="setting">
                {{ __('messages.account_profile') }}
            </x-sidebar-link>
        </div>
    </nav>

    <!-- Logout footer -->
    <div class="mt-10 pt-6 border-t border-white/5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-rose-500 transition-all text-[11px] font-black uppercase tracking-widest w-full text-left">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013-3v1" /></svg>
                {{ __('messages.logout') }}
            </button>
        </form>
    </div>
</div>
