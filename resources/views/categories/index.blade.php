<x-app-layout>
    <div class="space-y-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-slate-200 pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Classification System</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Categories & Racks</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Organize and locate physical assets across the facility</p>
            </div>
            
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('petugas'))
                <button onclick="window.location.href='{{ route('categories.create') }}'" class="px-8 py-4 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#062C2C]/20 hover:bg-[#041E1E] hover:scale-105 transition-all active:scale-95 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Category
                </button>
            @endif
        </div>

        <!-- Grid of Category Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                @php
                    $earthTone = match(strtolower($category->name)) {
                        'teknologi' => 'border-[#4F7942]', // Hijau Lumut
                        'sains' => 'border-[#8B4513]', // Cokelat Tanah
                        'fiksi' => 'border-[#556B2F]', // Dark Olive
                        'sejarah' => 'border-[#704214]', // Sepia
                        default => 'border-[#B8860B]' // Mustard
                    };
                    $icon = match(strtolower($category->name)) {
                        'teknologi' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                        'sains' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.387a2 2 0 01-1.132.252l-1.428-.142a4 4 0 00-1.554.124l-1.428.477a2 2 0 01-1.132-.252l-.691-.387a6 6 0 00-3.86-.517l-2.387.477a2 2 0 00-1.022.547"/></svg>',
                        default => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>'
                    };
                @endphp
                <div class="premium-card p-8 rounded-[2.5rem] relative overflow-hidden group border-l-8 {{ $earthTone }}">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-[#062C2C] group-hover:bg-[#062C2C] group-hover:text-white transition-all">
                            {!! $icon !!}
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Rack Location</p>
                            <h4 class="text-4xl font-light text-slate-100 uppercase tracking-tighter leading-none group-hover:text-[#B8860B] transition-colors">
                                {{ $category->rack ?? '00' }}
                            </h4>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-xl font-black text-[#062C2C] uppercase tracking-tight">{{ $category->name }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $category->books_count ?? 0 }} Registered Volumes</p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex gap-2">
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('petugas'))
                                <a href="{{ route('categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-[#B8860B] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this classification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('books.index', ['category' => $category->slug]) }}" class="text-[9px] font-black text-[#062C2C] uppercase tracking-widest flex items-center gap-2 group-hover:underline">
                            Explore Assets <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
