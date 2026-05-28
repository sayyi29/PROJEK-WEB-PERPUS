<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('borrowings.index') }}" 
               class="p-4 bg-white/5 rounded-[1.5rem] hover:bg-white/10 transition-all duration-300 text-indigo-400 border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase leading-none mb-1">@lang('messages.borrowing_create_header')</h2>
                <p class="text-indigo-400 font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">@lang('messages.borrowing_form_subtitle')</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6">
            <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-10">
                @csrf
                <div class="glass-card p-12 rounded-[3.5rem] border border-white/10 shadow-[0_50px_100px_rgba(0,0,0,0.4)] relative overflow-hidden group">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px]"></div>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-10">
                        @role('anggota')
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.borrower_label')</label>
                                <div class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white/50 font-bold">
                                    {{ Auth::user()->name }} (@lang('messages.you'))
                                </div>
                            </div>
                        @else
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.borrower_label')</label>
                                <div class="relative">
                                    <select name="user_id" required class="w-full bg-slate-900 border border-white/10 rounded-3xl px-8 py-5 text-white appearance-none cursor-pointer focus:ring-4 focus:ring-indigo-500/20">
                                        <option value="" disabled selected>@lang('messages.select_member_placeholder')</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->email }})</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-indigo-400 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('user_id') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                            </div>
                        @endrole

                        <div class="md:col-span-2 space-y-3">
                            <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.borrowing_book')</label>
                            <div class="relative">
                                <select name="book_id" required class="w-full bg-slate-900 border border-white/10 rounded-3xl px-8 py-5 text-white appearance-none cursor-pointer focus:ring-4 focus:ring-indigo-500/20">
                                    <option value="" disabled selected>@lang('messages.select_book_placeholder')</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }} (@lang('messages.stock_available'): {{ $book->stock }})</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-indigo-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('book_id') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.borrow_date_label')</label>
                            <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                            @error('borrow_date') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-indigo-300/60 uppercase tracking-[0.2em] ml-2">@lang('messages.due_date_label')</label>
                            <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-3xl px-8 py-5 text-white focus:ring-4 focus:ring-indigo-500/20">
                            @error('due_date') <p class="text-pink-400 text-xs font-bold mt-2 ml-2 italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-8 px-6">
                    <button type="submit" class="w-full py-7 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl active:scale-95 transition-all hover:bg-indigo-500 hover:shadow-indigo-500/20">
                        @lang('messages.process_borrowing_button')
                    </button>
                    
                    <a href="{{ route('borrowings.index') }}" class="block w-full py-6 bg-white/5 text-white/40 font-black text-center text-[10px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-white/10 hover:text-white transition-all">
                        @lang('messages.cancel_borrowing_button')
                    </a>
                </div>
            </form>
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

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.5;
            cursor: pointer;
        }
    </style>
</x-app-layout>
