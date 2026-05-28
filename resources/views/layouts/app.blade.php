<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LUMINA - Future Library</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #041E1E; /* Deep Forest Green (Sidebar Area) */
            color: #062C2C; /* Deep Green Text */
        }
        .main-content-bg {
            background-color: #F9F7F2; /* Soft Ivory/Paper Background */
            border-top-left-radius: 4rem; 
            box-shadow: -20px 0 60px rgba(0,0,0,0.05);
            position: relative;
        }
        /* Sidebar: Night Forest */
        .sidebar-dark {
            background-color: #062C2C; /* Deep Bottle Green */
            width: 280px;
            border-right: 1px solid rgba(255,255,255,0.02);
        }
        
        /* Glassmorphism elements - Refined for Soft Paper */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(6, 44, 44, 0.05);
            box-shadow: 0 15px 35px rgba(6, 44, 44, 0.03);
        }

        .premium-card {
            background: #FFFFFF; /* Pure White on Ivory */
            border: 1px solid #E8E4D9; /* Warm border to match Ivory */
            box-shadow: 0 10px 30px rgba(6, 44, 44, 0.02);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            border-color: #B8860B; 
            box-shadow: 0 30px 60px rgba(6, 44, 44, 0.06);
            transform: translateY(-5px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #062C2C; 
            border-radius: 10px;
            border: 3px solid #F9F7F2;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #062C2C; 
            border-radius: 10px;
            border: 3px solid #F2F4F4;
        }
        ::-webkit-scrollbar-thumb:hover { 
            background: #041E1E;
        }
        
        .neo-gradient {
            background: linear-gradient(135deg, #062C2C 0%, #041E1E 100%);
        }
    </style>
</head>
<body class="h-full antialiased overflow-hidden">
    @include('sweetalert::alert')
    
    <div class="flex h-full box-border neo-gradient">
        <!-- Sidebar Navigation (Dark) -->
        <aside class="sidebar-dark flex-shrink-0 flex flex-col h-full z-10">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content Area (Light Surface for Readability) -->
        <div class="flex-1 main-content-bg flex flex-col min-w-0 overflow-hidden mt-4">
            <!-- Header (Floating Style) -->
            <header class="px-12 pt-8 pb-4 flex items-center justify-between">
                <div>
                    @if(request()->routeIs('dashboard'))
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-[#0F172A] rounded-full"></div>
                            <h1 class="text-4xl font-extrabold tracking-tighter text-[#0F172A]">DISCOVER</h1>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-6">
                    <!-- Language Switcher -->
                    <div class="flex items-center bg-white rounded-2xl border border-slate-100 p-1 shadow-sm">
                        <a href="{{ route('lang.switch', 'id') }}" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'id' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-slate-900' }}">
                            ID
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-400 hover:text-slate-900' }}">
                            EN
                        </a>
                    </div>

                    <!-- Activity Notification -->
                    <livewire:activity-notifications />

                    <!-- Profile Trigger -->
                    <div x-data="{ open: false }" class="relative">
                        <div @click="open = !open" class="flex items-center gap-4 bg-white p-1.5 pr-5 rounded-2xl border border-slate-100 cursor-pointer hover:shadow-lg transition-all active:scale-95 group">
                            <div class="h-10 w-10 rounded-xl overflow-hidden shadow-inner bg-slate-100">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-900 font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Authenticated</p>
                                <p class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ Auth::user()->name }}</p>
                            </div>
                        </div>

                        <!-- Dropdown Glass Card -->
                        <div x-show="open" 
                             @click.away="open = false" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-4 w-72 bg-white rounded-3xl border border-slate-200 shadow-[0_30px_60px_rgba(0,0,0,0.1)] overflow-hidden z-[100] p-6">
                            
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 rounded-2xl mx-auto mb-4 border-4 border-slate-50 shadow-xl overflow-hidden">
                                     @if (Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <h3 class="text-sm font-black text-slate-900 uppercase">{{ Auth::user()->name }}</h3>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Level: Prime Explorer</p>
                            </div>

                            <div class="space-y-2 mb-6">
                                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 transition-all group">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Settings</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-amber-600 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                                    Disconnect
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Scroll -->
            <main class="flex-1 overflow-y-auto px-12 pb-12">
                <div class="py-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>
