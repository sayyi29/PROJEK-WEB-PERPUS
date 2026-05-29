<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LUMINA - Future Library</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            [x-cloak] { display: none !important; }
            body { 
                font-family: 'Plus Jakarta Sans', sans-serif; 
                background-color: #F9F7F2; /* Soft Ivory/Paper Background */
                color: #062C2C; /* Deep Green Text */
            }
            
            .hero-gradient {
                background: linear-gradient(135deg, #062C2C 0%, #041E1E 100%);
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
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

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }

            .text-gold {
                color: #B8860B;
            }

            .bg-dark-green {
                background-color: #062C2C;
            }
        </style>
    </head>
    <body class="h-full antialiased transition-colors duration-500">
        <div class="relative min-h-full flex flex-col">
            <!-- Navigation -->
            <nav class="p-8 flex items-center justify-between relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-[#062C2C] rounded-2xl flex items-center justify-center shadow-2xl">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-tighter leading-none text-[#062C2C]">LUMINA</span>
                        <span class="text-[10px] font-bold text-[#B8860B] tracking-[0.3em] uppercase mt-1">FUTURE LIBRARY</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Global Search -->
                    <livewire:global-search />

                    <div class="flex gap-2 bg-white p-1.5 rounded-xl border border-[#E8E4D9] shadow-sm">
                        <a href="{{ route('lang.switch', 'id') }}" class="px-2 py-1 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'id' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() == 'en' ? 'bg-[#062C2C] text-white shadow-lg' : 'text-slate-400 hover:text-[#062C2C]' }}">EN</a>
                    </div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-[#041E1E] hover:scale-105 transition-all duration-300 active:scale-95 shadow-xl">@lang('messages.dashboard')</a>
                        @else
                            <a href="{{ route('login') }}" class="font-black text-xs uppercase tracking-[0.2em] text-[#062C2C] hover:text-[#B8860B] transition-colors">@lang('messages.sign_in')</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-3 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-[#041E1E] hover:scale-105 transition-all duration-300 active:scale-95 shadow-2xl">@lang('messages.register')</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-1 flex flex-col items-center justify-center px-6 relative z-10 text-center py-20">
                <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-[#062C2C]/5 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 -right-40 w-[700px] h-[700px] bg-[#B8860B]/5 rounded-full blur-[150px]"></div>

                <div class="bg-white border border-[#E8E4D9] p-2 px-8 rounded-full mb-10 inline-block shadow-sm">
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#B8860B]">@lang('messages.digital_knowledge_hub')</span>
                </div>

                <h1 class="text-7xl md:text-9xl font-black tracking-tighter mb-10 leading-[0.9] text-[#062C2C]">
                    @lang('messages.knowledge_is')<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#062C2C] via-[#B8860B] to-[#041E1E]">@lang('messages.infinite')</span>
                </h1>

                <p class="text-xl md:text-2xl text-[#062C2C]/60 max-w-3xl mb-14 font-medium leading-relaxed">
                    @lang('messages.library_welcome_description')
                </p>

                <div class="flex flex-col sm:flex-row gap-8 mb-32">
                    <a href="{{ route('register') }}" class="px-12 py-6 bg-[#062C2C] text-white font-black text-sm uppercase tracking-[0.2em] rounded-3xl shadow-[0_20px_50px_rgba(6,44,44,0.2)] hover:bg-[#041E1E] hover:scale-105 transition-all duration-300 active:scale-95">
                        @lang('messages.start_reading')
                    </a>
                    <a href="{{ route('books.index') }}" class="px-12 py-6 bg-white border border-[#E8E4D9] text-[#062C2C] font-black text-sm uppercase tracking-[0.2em] rounded-3xl hover:bg-slate-50 transition-all duration-300 shadow-sm">
                        @lang('messages.explore_books')
                    </a>
                </div>

                <!-- Dynamic Content Sections -->
                <div class="w-full max-w-7xl mx-auto space-y-32">
                    <!-- Latest Books -->
                    <section>
                        <div class="flex items-end justify-between mb-12">
                            <div class="text-left">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#B8860B] mb-2">New Arrivals</p>
                                <h2 class="text-4xl font-black tracking-tight text-[#062C2C]">Koleksi Terbaru</h2>
                            </div>
                            <a href="{{ route('books.index') }}" class="text-xs font-bold uppercase tracking-widest text-[#062C2C] hover:text-[#B8860B] transition-colors">Lihat Semua →</a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @forelse($latestBooks as $book)
                                <div class="premium-card rounded-[2rem] p-6 text-left group">
                                    <div class="aspect-[3/4] bg-[#F9F7F2] rounded-2xl mb-6 overflow-hidden relative">
                                        @if($book->cover_image)
                                            <img src="{{ str_starts_with($book->cover_image, 'http') ? str_replace('http://', 'https://', $book->cover_image) : asset('storage/' . $book->cover_image) }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-[#062C2C]/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-[#062C2C]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-[#B8860B] mb-1">{{ $book->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="font-black text-lg leading-tight mb-2 line-clamp-2 text-[#062C2C]">{{ $book->title }}</h3>
                                    <p class="text-xs text-[#062C2C]/40 font-medium">{{ $book->author }}</p>
                                </div>
                            @empty
                                <p class="col-span-full text-center text-[#062C2C]/20 py-10 italic">Belum ada koleksi terbaru.</p>
                            @endforelse
                        </div>
                    </section>

                    <!-- Popular Books -->
                    <section>
                        <div class="flex items-end justify-between mb-12">
                            <div class="text-left">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#B8860B] mb-2">Global Trends</p>
                                <h2 class="text-4xl font-black tracking-tight text-[#062C2C]">Buku Terpopuler</h2>
                            </div>
                            <span class="text-[10px] font-bold text-[#062C2C]/20 uppercase tracking-widest">Powered by Google Books</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @forelse($externalBooks as $item)
                                @php
                                    $info = $item['volumeInfo'] ?? [];
                                    $title = $info['title'] ?? 'Unknown Title';
                                    $author = implode(', ', $info['authors'] ?? ['Unknown Author']);
                                    $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                                    
                                    if ($cover) {
                                        $cover = str_replace('http://', 'https://', $cover);
                                    } else {
                                        $cover = 'https://via.placeholder.com/300x450?text=' . urlencode($title);
                                    }
                                @endphp
                                <div class="premium-card rounded-[2rem] p-6 text-left group">
                                    <div class="aspect-[3/4] bg-[#F9F7F2] rounded-2xl mb-6 overflow-hidden relative">
                                        @if($cover)
                                            <img src="{{ $cover }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-[#062C2C]/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-[#062C2C]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-3 h-3 text-[#B8860B]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        <span class="text-[10px] font-black text-[#B8860B] uppercase tracking-widest">Trending Now</span>
                                    </div>
                                    <h3 class="font-black text-lg leading-tight mb-2 line-clamp-2 text-[#062C2C]">{{ $title }}</h3>
                                    <p class="text-xs text-[#062C2C]/40 font-medium line-clamp-1">{{ $author }}</p>
                                </div>
                            @empty
                                <p class="col-span-full text-center text-[#062C2C]/20 py-10 italic">Gagal memuat buku populer.</p>
                            @endforelse
                        </div>
                    </section>
                </div>

                <!-- Floating Book Element -->
                <div class="mt-24 flex justify-center w-full relative z-10 animate-float">
                    <div class="w-72 h-96 md:w-80 md:h-[450px] bg-white rounded-[3rem] border border-[#E8E4D9] shadow-[0_50px_100px_rgba(6,44,44,0.1)] flex flex-col items-center justify-center p-10 overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#062C2C]/5 to-[#B8860B]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <div class="w-32 h-32 mb-8 bg-[#062C2C] rounded-3xl flex items-center justify-center shadow-2xl">
                             <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-[#B8860B] mb-2">@lang('messages.editors_choice')</p>
                        <h4 class="text-xl font-black text-center text-[#062C2C] leading-tight">@lang('messages.mastering_digital_transformation')</h4>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="p-10 text-center text-[10px] font-black text-[#062C2C]/30 relative z-10 uppercase tracking-[0.3em]">
                @lang('messages.footer_text', ['year' => date('Y'), 'appName' => config('app.name')])
            </footer>
        </div>
        @livewireScripts
    </body>
</html>

