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
            background-color: #062C2C; /* Background base for sidebar transition */
            color: #1E293B;
            margin: 0;
            padding: 0;
        }

        .app-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: #062C2C;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 280px;
            flex-shrink: 0;
            background-color: #062C2C;
            z-index: 50;
        }

        /* Main Workspace Content Area */
        .main-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-color: #F4F4F0; /* Soft Bone transition */
        }

        /* The signature rounded ivory surface */
        .content-area {
            flex: 1;
            overflow-y: auto;
            background-color: #F9F7F2; /* Soft Ivory/Paper surface */
            border-top-left-radius: 4rem; 
            box-shadow: -20px 0 60px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Premium White Cards */
        .premium-card {
            background: #FFFFFF;
            border: 1px solid #E8E4D9;
            box-shadow: 0 10px 30px rgba(6, 44, 44, 0.02);
            border-radius: 2.5rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Clean Dropdowns - Remove default arrow */
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: none !important; /* Remove Tailwind Forms plugin arrow */
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(6, 44, 44, 0.06);
            border-color: #B8860B;
        }

        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: #B8860B; /* Gold Thumb */
            border-radius: 10px;
            border: 2px solid #F9F7F2;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
            background: #8B6508;
        }

        /* Global Scrollbar Override */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F9F7F2; }
        ::-webkit-scrollbar-thumb { 
            background: #B8860B; 
            border-radius: 10px;
            border: 2px solid #F9F7F2;
        }
        ::-webkit-scrollbar-thumb:hover { 
            background: #8B6508;
        }
    </style>
</head>
<body class="h-full antialiased overflow-hidden">
    @include('sweetalert::alert')
    
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content Area -->
        <div class="main-workspace">
            <!-- Header (Floating Style) -->
            <header class="px-12 pt-8 pb-4 flex items-center justify-between">
                <div>
                    @if(request()->routeIs('dashboard'))
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-[#062C2C] rounded-full"></div>
                            <h1 class="text-4xl font-extrabold tracking-tighter text-[#062C2C] uppercase italic">Discover</h1>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-6">
                    <!-- Global Search Component (Dashboard Only) -->
                    @if(request()->routeIs('dashboard'))
                        <livewire:global-search />
                    @endif

                    <div class="flex items-center gap-4">
                        <!-- Language Switcher -->
                        <div class="flex bg-white rounded-xl border border-slate-200 p-1 shadow-sm">
                            <a href="{{ route('lang.switch', 'id') }}" 
                               class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'id' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">
                                ID
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" 
                               class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">
                                EN
                            </a>
                        </div>

                        <!-- Activity Notifications -->
                        <livewire:activity-notifications />
                    </div>

                    <!-- User Profile Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-4 bg-white p-1.5 pr-5 rounded-2xl border border-slate-200 cursor-pointer hover:shadow-lg transition-all active:scale-95 group">
                            <div class="h-10 w-10 rounded-xl overflow-hidden shadow-inner bg-slate-50">
                                @if (Auth::user()?->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                @elseif(Auth::user())
                                    <div class="w-full h-full flex items-center justify-center text-[#062C2C] font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Authenticated</p>
                                <p class="text-xs font-black text-[#062C2C] uppercase tracking-tight">{{ Auth::user()?->name ?? 'Guest' }}</p>
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-4 w-72 bg-white rounded-3xl border border-slate-200 shadow-[0_30px_60px_rgba(0,0,0,0.15)] overflow-hidden z-[100] p-6">
                            
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 rounded-2xl mx-auto mb-4 border-4 border-slate-50 shadow-xl overflow-hidden bg-slate-100 flex items-center justify-center">
                                     @if (Auth::user()?->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-3xl font-black text-[#062C2C]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <h3 class="text-sm font-black text-[#062C2C] uppercase">{{ Auth::user()->name }}</h3>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Prime Operative</p>
                            </div>

                            <div class="space-y-2 mb-6">
                                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 transition-all group">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Protocol Settings</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </a>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-[#062C2C] text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-rose-700 transition-all shadow-xl active:scale-95">
                                    Terminate Session
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Scroll Area -->
            <main class="content-area custom-scrollbar">
                <div class="px-12 py-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>