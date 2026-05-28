<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('books.index') }}" 
               class="p-4 bg-white/5 rounded-[1.5rem] hover:bg-white/10 transition-all duration-300 text-indigo-400 border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase leading-none mb-1">@lang('messages.edit_book')</h2>
                <p class="text-indigo-400 font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">@lang('messages.book_update_info')</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        imagePreview: '{{ $book->cover_image ? (Str::startsWith($book->cover_image, 'http') ? $book->cover_image : asset('storage/' . $book->cover_image)) : null }}',
    }">
        <div class="space-y-12">
            <!-- Manual Input Section (Adapted for Edit) -->
            <div class="space-y-10">
                <div class="px-12">
                    <h3 class="text-2xl font-black text-white tracking-tight uppercase tracking-widest">@lang('messages.book_details')</h3>
                    <p class="text-indigo-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">@lang('messages.collection_id'): #{{ str_pad($book->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>

                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        <div class="lg:col-span-8 space-y-10">
                            <div class="glass-card p-12 rounded-[3.5rem] border border-white/10 shadow-[0_50px_100px_rgba(0,0,0,0.4)] relative overflow-hidden group">
                                <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px]"></div>
                                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10">
                                    <div class="md:col-span-2 space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.title')</label>
                                        <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 font-medium text-lg"
                                            placeholder="@lang('messages.enter_book_title')">
                                        @error('title') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.isbn')</label>
                                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20"
                                            placeholder="ISBN-13/10">
                                        @error('isbn') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.genre')</label>
                                        <input type="text" name="genre" value="{{ old('genre', $book->genre) }}"
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20"
                                            placeholder="@lang('messages.enter_genre')">
                                        @error('genre') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.category')</label>
                                        <div class="relative">
                                            <select name="category_id" required
                                                class="w-full bg-slate-900 border border-white/10 rounded-3xl px-8 py-5 text-white appearance-none cursor-pointer">
                                                <option value="" disabled>@lang('messages.select_category')</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-indigo-400 pointer-events-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                        @error('category_id') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.author')</label>
                                        <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                                        @error('author') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.publisher')</label>
                                        <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                                        @error('publisher') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.year')</label>
                                        <input type="number" name="year" value="{{ old('year', $book->year) }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                                        @error('year') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4 space-y-10">
                            <div class="glass-card p-10 rounded-[3.5rem] border border-white/10 flex flex-col items-center">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.3em] mb-10 block w-full text-left ml-2">@lang('messages.cover_image')</label>
                                <div class="relative w-full aspect-[3/4.5] rounded-[2.5rem] overflow-hidden bg-black/40 border-2 border-dashed border-white/10 cursor-pointer shadow-2xl group/img">
                                    <input type="file" name="cover_image" class="absolute inset-0 opacity-0 cursor-pointer z-10" 
                                        @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result }; reader.readAsDataURL(file); }">
                                    
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110">
                                    </template>
                                    
                                    <template x-if="!imagePreview">
                                        <div class="flex flex-col items-center justify-center h-full text-indigo-400">
                                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-40">@lang('messages.click_to_upload')</span>
                                        </div>
                                    </template>

                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                        <span class="text-white font-black text-xs uppercase tracking-[0.2em]">@lang('messages.change_cover')</span>
                                    </div>
                                </div>
                                @error('cover_image') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="flex flex-col gap-12 mt-6">
                                <button type="submit" class="w-full py-7 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl active:scale-95 transition-all hover:bg-indigo-500 hover:shadow-indigo-500/20">
                                    @lang('messages.update_book')
                                </button>
                                
                                <div class="relative py-4">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-white/5"></div>
                                    </div>
                                    <div class="relative flex justify-center text-[10px] uppercase tracking-[0.5em] font-black text-white/10 italic">
                                        <span class="bg-[#0f172a] px-4">@lang('messages.or')</span>
                                    </div>
                                </div>

                                <a href="{{ route('books.index') }}" class="block w-full py-6 bg-white/5 text-white/40 font-black text-center text-[10px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-white/10 hover:text-white transition-all">
                                    @lang('messages.cancel_changes')
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }
        
        select::-ms-expand {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; border: 3px solid transparent; background-clip: content-box; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.4); border: 2px solid transparent; background-clip: content-box; }
    </style>
</x-app-layout>
