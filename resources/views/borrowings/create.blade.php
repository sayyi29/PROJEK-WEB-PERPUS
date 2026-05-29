<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('borrowings.index') }}" 
               class="p-4 bg-[#062C2C] rounded-[1.5rem] hover:bg-[#041E1E] transition-all duration-300 text-white border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">New Borrowing</h2>
                <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Initialize Asset Protocol</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        search: '', 
        open: false, 
        selectedBook: null,
        books: {{ $books->map(function($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'stock' => $book->stock,
                'cover' => $book->cover_image_url,
                'category' => $book->category->name
            ];
        })->toJson() }},
        get filteredBooks() {
            if (this.search === '') return this.books;
            return this.books.filter(book => 
                book.title.toLowerCase().includes(this.search.toLowerCase()) || 
                book.author.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        selectBook(book) {
            if(book.stock > 0) {
                this.selectedBook = book;
                this.open = false;
                this.search = '';
            }
        }
    }">
        <div class="max-w-4xl mx-auto px-6">
            <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-12">
                @csrf
                <div class="bg-[#062C2C] p-12 rounded-[4rem] border border-white/5 shadow-[0_50px_100px_rgba(0,0,0,0.3)] relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/5 rounded-full blur-[80px]"></div>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-12">
                        @role('anggota')
                            <div class="md:col-span-2 space-y-4">
                                <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Authenticated Operative</label>
                                <div class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white/90 font-bold text-sm">
                                    {{ Auth::user()->name }}
                                </div>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </div>
                        @else
                            <div class="md:col-span-2 space-y-4">
                                <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Select Target Operative</label>
                                <div class="relative group">
                                    <select name="user_id" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white font-bold text-sm appearance-none cursor-pointer focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all">
                                        <option value="" disabled selected class="bg-[#062C2C]">Select Member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" class="bg-[#062C2C]">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[#B8860B] pointer-events-none group-hover:translate-y-[-40%] transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('user_id') <p class="text-rose-400 text-[10px] font-black mt-2 ml-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                        @endrole

                        <!-- Advanced Asset Selector -->
                        <div class="md:col-span-2 space-y-6">
                            <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Identify Asset Protocol</label>
                            
                            <div class="relative">
                                <!-- Search Input -->
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-[#B8860B]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input type="text" 
                                           x-model="search"
                                           @focus="open = true"
                                           @click.away="open = false"
                                           placeholder="Discover asset by title or author..."
                                           class="w-full bg-white/5 border border-white/10 rounded-2xl pl-16 pr-8 py-5 text-white font-bold text-sm focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all placeholder-white/20">
                                    
                                    <input type="hidden" name="book_id" :value="selectedBook ? selectedBook.id : ''" required>
                                </div>

                                <!-- Dropdown Results -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="absolute top-full left-0 right-0 mt-4 bg-[#041E1E] border border-white/10 rounded-3xl shadow-[0_30px_60px_rgba(0,0,0,0.5)] z-50 overflow-hidden max-h-96 overflow-y-auto custom-scrollbar">
                                    
                                    <template x-for="book in filteredBooks" :key="book.id">
                                        <div @click="selectBook(book)" 
                                             class="p-4 flex items-center gap-5 hover:bg-white/5 cursor-pointer transition-colors border-b border-white/5 last:border-0"
                                             :class="book.stock <= 0 ? 'opacity-40 cursor-not-allowed' : ''">
                                            <div class="w-12 h-16 rounded-lg overflow-hidden flex-shrink-0 border border-white/10">
                                                <img :src="book.cover" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-black text-white uppercase leading-tight" x-text="book.title"></h4>
                                                    <span class="text-[8px] font-black px-2 py-0.5 rounded-md uppercase tracking-tighter" 
                                                          :class="book.stock > 0 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400'"
                                                          x-text="book.stock > 0 ? book.stock + ' Available' : 'Out of Stock'"></span>
                                                </div>
                                                <p class="text-[10px] font-bold text-[#B8860B] uppercase tracking-widest mt-1" x-text="book.author"></p>
                                            </div>
                                        </div>
                                    </template>

                                    <div x-show="filteredBooks.length === 0" class="p-10 text-center text-white/20 uppercase text-[10px] font-black tracking-widest">
                                        No assets matching criteria
                                    </div>
                                </div>
                            </div>

                            <!-- Visual Confirmation Card -->
                            <div x-show="selectedBook" 
                                 x-transition:enter="transition ease-out duration-500"
                                 x-transition:enter-start="opacity-0 -translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="p-6 bg-white/5 border border-[#B8860B]/30 rounded-3xl flex items-center gap-8 relative group overflow-hidden">
                                <div class="absolute inset-0 bg-[#B8860B]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="w-20 h-28 rounded-xl overflow-hidden shadow-2xl border border-white/10 relative z-10">
                                    <img :src="selectedBook ? selectedBook.cover : ''" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 relative z-10">
                                    <p class="text-[9px] font-black text-[#B8860B] uppercase tracking-[0.3em] mb-2">Protocol Locked</p>
                                    <h3 class="text-xl font-black text-white uppercase tracking-tighter" x-text="selectedBook ? selectedBook.title : ''"></h3>
                                    <div class="flex items-center gap-4 mt-3">
                                        <p class="text-xs font-bold text-white/40 uppercase tracking-widest" x-text="selectedBook ? selectedBook.author : ''"></p>
                                        <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-tighter" x-text="selectedBook ? selectedBook.stock + ' units remaining' : ''"></p>
                                    </div>
                                </div>
                                <button type="button" @click="selectedBook = null" class="absolute top-4 right-4 text-white/20 hover:text-rose-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Initiation Date</label>
                            <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white font-bold text-sm focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all">
                            @error('borrow_date') <p class="text-rose-400 text-[10px] font-black mt-2 ml-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Return Deadline</label>
                            <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white font-bold text-sm focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all">
                            @error('due_date') <p class="text-rose-400 text-[10px] font-black mt-2 ml-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 max-w-lg mx-auto">
                    <button type="submit" 
                            :disabled="!selectedBook"
                            :class="!selectedBook ? 'opacity-50 cursor-not-allowed bg-slate-800' : 'bg-[#B8860B] hover:bg-[#8B6508] shadow-2xl'"
                            class="w-full py-6 text-white font-black text-[10px] uppercase tracking-[0.4em] rounded-2xl active:scale-95 transition-all border border-white/5">
                        Confirm Initiation
                    </button>
                    
                    <a href="{{ route('borrowings.index') }}" class="block w-full py-5 bg-white/5 text-white/30 font-black text-center text-[9px] uppercase tracking-[0.4em] rounded-2xl hover:bg-white/10 hover:text-white transition-all">
                        Abort Protocol
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: none !important;
        }
        select::-ms-expand {
            display: none !important;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.3;
            cursor: pointer;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</x-app-layout>