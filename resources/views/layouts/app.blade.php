<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LUMINA - Future Library</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #062C2C;
            color: #1E293B;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        /* Premium White Cards */
        .premium-card {
            background: #FFFFFF;
            border: 1px solid #E8E4D9;
            box-shadow: 0 8px 24px rgba(6, 44, 44, 0.04);
            border-radius: 1.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px rgba(6, 44, 44, 0.08);
            border-color: #B8860B;
        }

        /* Normalized form inputs */
        input[type="text"], input[type="email"], input[type="password"],
        input[type="file"], textarea, select {
            border-radius: 0.875rem !important;
        }

        /* Clean Dropdowns */
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: none !important;
        }

        /* =============================================
           SLIM SIDEBAR STYLES
        ============================================= */
        .slim-sidebar {
            width: 72px;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Tooltip on hover */
        .nav-item {
            position: relative;
        }
        .nav-item .tooltip {
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%);
            background: #1E293B;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s ease, transform 0.15s ease;
            transform: translateY(-50%) translateX(-6px);
            z-index: 200;
        }
        .nav-item .tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1E293B;
        }
        .nav-item:hover .tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        /* Accordion sub-menu */
        .sub-menu {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sub-menu.open {
            max-height: 200px;
        }

        /* Flyout sub-menu (appears to the right of icon) */
        .flyout-menu {
            position: absolute;
            left: calc(100% + 10px);
            top: 0;
            background: #0A3D3D;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 8px;
            min-width: 200px;
            opacity: 0;
            pointer-events: none;
            transform: translateX(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 300;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .flyout-menu.open {
            opacity: 1;
            pointer-events: all;
            transform: translateX(0);
        }
        .flyout-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            transition: all 0.2s;
            text-decoration: none;
        }
        .flyout-item:hover, .flyout-item.active {
            background: rgba(255,255,255,0.08);
            color: #B8860B;
        }
        .flyout-title {
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
            padding: 4px 12px 6px;
        }

        /* Nav icon button */
        .nav-icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.3);
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: transparent;
        }
        .nav-icon-btn:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .nav-icon-btn.active {
            background: rgba(184, 134, 11, 0.15);
            color: #B8860B;
            box-shadow: 0 0 0 1px rgba(184,134,11,0.3);
        }

        /* Badge */
        .nav-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #B8860B;
            color: white;
            font-size: 8px;
            font-weight: 900;
            border-radius: 99px;
            padding: 1px 4px;
            min-width: 14px;
            text-align: center;
            line-height: 1.4;
        }
        .nav-badge.danger {
            background: #be123c;
        }

        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: #B8860B;
            border-radius: 10px;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F9F7F2; }
        ::-webkit-scrollbar-thumb { 
            background: #B8860B;
            border-radius: 10px;
        }
    </style>
</head>
<body class="h-screen antialiased overflow-hidden">
    @include('sweetalert::alert')
    
    <!-- App Container: Full Viewport Locked -->
    <div class="flex h-screen w-screen overflow-hidden bg-[#062C2C]">
        
        <!-- ===== SLIM SIDEBAR ===== -->
        <aside class="slim-sidebar shrink-0 bg-[#062C2C] z-50 h-screen flex flex-col items-center py-6 gap-1 relative overflow-visible">
            
            <!-- Logo: Icon Only -->
            <div class="mb-6 w-11 h-11 bg-[#B8860B] rounded-xl flex items-center justify-center text-[#062C2C] font-black text-lg shadow-lg shadow-[#B8860B]/20 shrink-0">
                L
            </div>

            @php
                $pendingMembers = \App\Models\User::role('anggota')->where('status', 'pending_approval')->count();
                $overdueCount   = \App\Models\Borrowing::where('status', 'overdue')->count();
                $unpaidFines    = \App\Models\Fine::where('status', 'unpaid')->count();
            @endphp

            <!-- ===== ADMIN MENU ===== -->
            @if(auth()->user()->hasRole('admin'))

                <!-- Dashboard -->
                <div class="nav-item relative">
                    <a href="{{ route('dashboard') }}" class="nav-icon-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </a>
                    <span class="tooltip">Dashboard</span>
                </div>

                <div class="w-8 h-px bg-white/5 my-2 shrink-0"></div>

                <!-- ── MASTER DATA GROUP (Flyout) ── -->
                <div class="nav-item relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="nav-icon-btn {{ request()->routeIs('books.*') || request()->routeIs('categories.*') || request()->routeIs('members.*') ? 'active' : '' }} relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        @if($pendingMembers > 0)
                            <span class="nav-badge">{{ $pendingMembers }}</span>
                        @endif
                    </button>
                    <span class="tooltip" x-show="!open">Master Data</span>

                    <!-- Flyout Panel -->
                    <div :class="open ? 'open' : ''" class="flyout-menu">
                        <p class="flyout-title">Master Data</p>
                        <a href="{{ route('books.index') }}" class="flyout-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            Book Data
                        </a>
                        <a href="{{ route('categories.index') }}" class="flyout-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                            Categories & Racks
                        </a>
                        <a href="{{ route('members.index') }}" class="flyout-item {{ request()->routeIs('members.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            Member Data
                            @if($pendingMembers > 0)
                                <span class="ml-auto bg-[#B8860B] text-white text-[8px] font-black px-1.5 py-0.5 rounded-md">{{ $pendingMembers }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- ── TRANSACTIONS GROUP (Flyout) ── -->
                <div class="nav-item relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="nav-icon-btn {{ request()->routeIs('borrowings.*') || request()->routeIs('returns.*') ? 'active' : '' }} relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        @if($overdueCount > 0)
                            <span class="nav-badge danger">{{ $overdueCount }}</span>
                        @endif
                    </button>
                    <span class="tooltip" x-show="!open">Transactions</span>

                    <!-- Flyout Panel -->
                    <div :class="open ? 'open' : ''" class="flyout-menu">
                        <p class="flyout-title">Circulation</p>
                        <a href="{{ route('borrowings.create') }}" class="flyout-item {{ request()->routeIs('borrowings.create') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Borrow
                        </a>
                        <a href="{{ route('returns.create') }}" class="flyout-item {{ request()->routeIs('returns.create') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                            Return
                        </a>
                        <a href="{{ route('borrowings.index') }}" class="flyout-item {{ request()->routeIs('borrowings.index') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            Borrowings
                            @if($overdueCount > 0)
                                <span class="ml-auto bg-rose-700 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md">{{ $overdueCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('returns.index') }}" class="flyout-item {{ request()->routeIs('returns.index') ? 'active' : '' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Returns
                        </a>
                    </div>
                </div>

                <!-- Finance & Reports: Fines -->
                <div class="nav-item relative">
                    <a href="{{ route('fines.index') }}" class="nav-icon-btn {{ request()->routeIs('fines.*') ? 'active' : '' }} relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @if($unpaidFines > 0)
                            <span class="nav-badge">{{ $unpaidFines }}</span>
                        @endif
                    </a>
                    <span class="tooltip">Fine History</span>
                </div>

                <!-- Reports -->
                <div class="nav-item relative">
                    <a href="{{ route('reports.index') }}" class="nav-icon-btn {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </a>
                    <span class="tooltip">Print Report</span>
                </div>

            @else
                <!-- ===== MEMBER MENU ===== -->
                @php
                    $activeLoans  = \App\Models\Borrowing::where('user_id', auth()->id())->where('status', 'borrowed')->count();
                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                @endphp

                <div class="nav-item relative">
                    <a href="{{ route('dashboard') }}" class="nav-icon-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </a>
                    <span class="tooltip">Dashboard</span>
                </div>

                <div class="nav-item relative">
                    <a href="{{ route('borrowings.create') }}" class="nav-icon-btn {{ request()->routeIs('borrowings.create') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </a>
                    <span class="tooltip">Borrow</span>
                </div>

                <div class="nav-item relative">
                    <a href="{{ route('returns.create') }}" class="nav-icon-btn {{ request()->routeIs('returns.create') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                    </a>
                    <span class="tooltip">Return</span>
                </div>

                <div class="nav-item relative">
                    <a href="{{ route('borrowings.index') }}" class="nav-icon-btn {{ request()->routeIs('borrowings.index') ? 'active' : '' }} relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        @if($activeLoans > 0)
                            <span class="nav-badge">{{ $activeLoans }}</span>
                        @endif
                    </a>
                    <span class="tooltip">My Collection</span>
                </div>

                <div class="nav-item relative">
                    <a href="{{ route('returns.index') }}" class="nav-icon-btn {{ request()->routeIs('returns.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </a>
                    <span class="tooltip">Reading History</span>
                </div>

                <div class="nav-item relative">
                    <a href="{{ route('wishlist.index') }}" class="nav-icon-btn {{ request()->routeIs('wishlist.index') ? 'active' : '' }} relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        @if($wishlistCount > 0)
                            <span class="nav-badge">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    <span class="tooltip">My Wishlist</span>
                </div>
            @endif

            <!-- Spacer -->
            <div class="flex-1"></div>

            <div class="w-8 h-px bg-white/5 my-1 shrink-0"></div>

            <!-- Account Profile -->
            <div class="nav-item relative">
                <a href="{{ route('profile.edit') }}" class="nav-icon-btn {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
                <span class="tooltip">Account Profile</span>
            </div>

            <!-- Logout -->
            <div class="nav-item relative">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-icon-btn hover:!text-rose-400 hover:!bg-rose-500/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </button>
                </form>
                <span class="tooltip">Logout</span>
            </div>

        </aside>

        <!-- ===== MAIN WORKSPACE ===== -->
        <div class="flex-1 flex flex-col min-w-0 bg-[#F4F4F0] h-screen overflow-hidden">

            <!-- Top Header -->
            <header class="px-6 pt-4 pb-3 flex items-center justify-between shrink-0 gap-4">
                <div class="min-w-0">
                    @if(request()->routeIs('dashboard'))
                        <div class="flex items-center gap-3">
                            <div class="h-6 w-1 bg-[#062C2C] rounded-full shrink-0"></div>
                            <h1 class="text-2xl font-extrabold tracking-tighter text-[#062C2C] uppercase italic truncate">Discover</h1>
                        </div>
                    @elseif(isset($header))
                        <div class="min-w-0">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <!-- Global Search (Dashboard Only) -->
                    @if(request()->routeIs('dashboard'))
                        <livewire:global-search />
                    @endif

                    <!-- Language Switcher -->
                    <div class="flex bg-white rounded-xl border border-slate-200 p-1 shadow-sm">
                        <a href="{{ route('lang.switch', 'id') }}" 
                           class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'id' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">EN</a>
                    </div>

                    <!-- Activity Notifications -->
                    <livewire:activity-notifications />

                    <!-- User Profile Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 bg-white p-1.5 pr-4 rounded-2xl border border-slate-200 cursor-pointer hover:shadow-lg transition-all active:scale-95 group">
                            <div class="h-9 w-9 rounded-xl overflow-hidden shadow-inner bg-slate-50">
                                @if (Auth::user()?->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                @elseif(Auth::user())
                                    <div class="w-full h-full flex items-center justify-center text-[#062C2C] font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">Authenticated</p>
                                <p class="text-[11px] font-black text-[#062C2C] uppercase tracking-tight">{{ Auth::user()?->name ?? 'Guest' }}</p>
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-cloak
                             style="display:none"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-3 w-64 bg-white rounded-2xl border border-slate-200 shadow-[0_20px_50px_rgba(0,0,0,0.12)] overflow-hidden z-[100] p-5">
                            
                            <div class="text-center mb-5">
                                <div class="w-16 h-16 rounded-2xl mx-auto mb-3 border-4 border-slate-50 shadow-xl overflow-hidden bg-slate-100 flex items-center justify-center">
                                     @if (Auth::user()?->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl font-black text-[#062C2C]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <h3 class="text-sm font-black text-[#062C2C] uppercase">{{ Auth::user()->name }}</h3>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Prime Operative</p>
                            </div>

                            <div class="space-y-1 mb-4">
                                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-600 transition-all group">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Protocol Settings</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </a>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-[#062C2C] text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-rose-700 transition-all shadow-lg active:scale-95">
                                    Terminate Session
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Scroll Area -->
            <main class="flex-1 overflow-y-auto bg-[#F9F7F2] rounded-tl-[2rem] shadow-[-12px_0_40px_rgba(0,0,0,0.1)] flex flex-col relative custom-scrollbar">
                <div class="px-6 py-6 min-h-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>