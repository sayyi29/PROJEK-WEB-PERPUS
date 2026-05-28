<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between border-b border-[#E8E4D9] pb-8 gap-8">
            <div class="flex-1">
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Digital Inventory</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Explore Library</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Access our complete digital collection with high-speed indexing</p>
            </div>
            <div class="w-full lg:max-w-2xl">
                <livewire:global-search />
            </div>
        </div>

        <!-- Filter Bar (SOP: Categories) -->
        <div class="flex items-center gap-4 overflow-x-auto pb-4 custom-scrollbar">
            <a href="{{ route('books.index') }}" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all {{ !request('category') ? 'bg-[#062C2C] text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300' }}">
                All Collections
            </a>
            @foreach(\App\Models\Category::all() as $cat)
                @php
                    $isActive = request('category') == $cat->slug;
                    $earthTone = match(strtolower($cat->name)) {
                        'teknologi' => 'bg-[#4F7942]', // Hijau Lumut
                        'sains' => 'bg-[#8B4513]', // Cokelat Tanah
                        'fiksi' => 'bg-[#556B2F]', // Dark Olive
                        'sejarah' => 'bg-[#704214]', // Sepia/Earth
                        default => 'bg-[#062C2C]'
                    };
                @endphp
                <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all {{ $isActive ? $earthTone . ' text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300' }}">
                    {{ Lang::has('messages.' . strtolower($cat->name)) ? __('messages.' . strtolower($cat->name)) : $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach($books as $book)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-3xl overflow-hidden shadow-xl transition-all duration-500 group-hover:-translate-y-2 border border-slate-50">
                        <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover">
                        
                        <!-- Stock Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-2 py-1 {{ $book->stock > 0 ? 'bg-[#B8860B]' : 'bg-rose-900' }} text-white text-[7px] font-black rounded-lg uppercase tracking-widest shadow-lg">
                                {{ $book->stock > 0 ? 'In Stock' : 'Loaned' }}
                            </span>
                        </div>

                        <!-- Info Overlay -->
                        <div class="absolute inset-0 bg-[#062C2C]/90 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-6">
                            @php
                                $earthToneText = match(strtolower($book->category->name)) {
                                    'teknologi' => 'text-[#9DC183]', // Lighter Moss
                                    'sains' => 'text-[#D2B48C]', // Tan/Earth
                                    default => 'text-[#B8860B]'
                                };
                            @endphp
                            <p class="text-[8px] font-black {{ $earthToneText }} uppercase tracking-widest mb-1">{{ $book->category->name }}</p>
                            <h4 class="text-xs font-black text-white uppercase leading-tight line-clamp-2 mb-4">{{ $book->title }}</h4>
                            <a href="{{ route('books.show', $book) }}" class="w-full py-2.5 bg-white text-[#062C2C] text-[9px] font-black uppercase tracking-widest rounded-xl text-center hover:bg-[#B8860B] hover:text-white transition-colors">
                                Access Protocol
                            </a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="font-black text-[#062C2C] truncate text-[10px] uppercase tracking-tight">{{ $book->title }}</h4>
                        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ Str::limit($book->author, 20) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-10">
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>
