<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex items-end justify-between border-b border-slate-200 pb-8">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Personal Collection</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">My Wishlist</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Books you've saved for future reading protocols</p>
            </div>
            <div class="text-right">
                <span class="px-6 py-2 bg-[#062C2C] text-white text-[10px] font-black rounded-full uppercase tracking-widest shadow-xl">
                    {{ $wishlists->count() }} Saved Items
                </span>
            </div>
        </div>

        @if($wishlists->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-24 bg-[#062C2C] rounded-[3rem] border border-dashed border-white/10">
                <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center text-white/20 mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </div>
                <h3 class="text-xl font-black text-white uppercase tracking-tight">Wishlist is Empty</h3>
                <p class="text-xs font-bold text-white/40 uppercase tracking-widest mt-2">Start exploring the library to save your favorite books</p>
                <a href="{{ route('dashboard') }}" class="mt-8 px-10 py-4 bg-[#B8860B] text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-[#8B6508] transition-all shadow-xl active:scale-95">
                    Explore Now
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($wishlists as $wishlist)
                    @php $book = $wishlist->book; @endphp
                    <div class="bg-[#062C2C] rounded-[2.5rem] border border-white/5 p-6 flex gap-6 hover:shadow-2xl transition-all group relative overflow-hidden">
                        <!-- Book Cover -->
                        <div class="relative h-full w-40 overflow-hidden rounded-2xl border border-white/10 shadow-lg">
                            <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <!-- Book Details -->
                        <div class="flex-1 flex flex-col justify-between py-2">
                            <div>
                                <p class="text-[9px] font-bold text-[#B8860B] uppercase tracking-widest mb-1">{{ $book->category->name }}</p>
                                <h4 class="text-sm font-black text-white uppercase leading-tight line-clamp-2">{{ $book->title }}</h4>
                                <p class="text-[10px] font-bold text-white/40 mt-2 uppercase tracking-tight">{{ $book->author }}</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('books.show', $book) }}" class="flex-1 text-center py-2.5 bg-white/10 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-white/20 transition-all">
                                    View
                                </a>
                                
                                <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-500/10 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm" onclick="return confirm('Remove this book?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Decor -->
                        <div class="absolute -bottom-6 -right-6 w-20 h-20 bg-white/5 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
