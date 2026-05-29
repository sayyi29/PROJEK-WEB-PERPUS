<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('returns.index') }}" 
               class="p-4 bg-[#062C2C] rounded-[1.5rem] hover:bg-[#041E1E] transition-all duration-300 text-white border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">Return Asset</h2>
                <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Complete Circulation Cycle</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <form action="{{ route('returns.store') }}" method="POST" class="space-y-12">
                @csrf
                <div class="bg-[#062C2C] p-12 rounded-[4rem] border border-white/5 shadow-[0_50px_100px_rgba(0,0,0,0.3)] relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/5 rounded-full blur-[80px]"></div>
                    
                    <div class="relative space-y-10">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Active Circulation Data</label>
                            <div class="relative group">
                                <select name="borrowing_id" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white font-bold text-sm appearance-none cursor-pointer focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all">
                                    <option value="" disabled selected class="bg-[#062C2C]">Select Borrowing Record</option>
                                    @foreach($borrowings as $b)
                                        <option value="{{ $b->id }}" class="bg-[#062C2C]">
                                            {{ $b->user->name }} • {{ $b->book->title }} (Due: {{ $b->due_date->format('d M Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[#B8860B] pointer-events-none group-hover:translate-y-[-40%] transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('borrowing_id') <p class="text-rose-400 text-[10px] font-black mt-2 ml-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] ml-2">Completion Timestamp</label>
                            <input type="date" name="return_date" value="{{ date('Y-m-d') }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white font-bold text-sm focus:ring-4 focus:ring-[#B8860B]/20 focus:border-[#B8860B] transition-all">
                            @error('return_date') <p class="text-rose-400 text-[10px] font-black mt-2 ml-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 max-w-lg mx-auto">
                    <button type="submit" class="w-full py-6 bg-[#062C2C] text-white font-black text-[10px] uppercase tracking-[0.4em] rounded-2xl shadow-2xl active:scale-95 transition-all hover:bg-[#041E1E] border border-white/5">
                        Finalize Return
                    </button>
                    
                    <a href="{{ route('returns.index') }}" class="block w-full py-5 bg-white/5 text-white/30 font-black text-center text-[9px] uppercase tracking-[0.4em] rounded-2xl hover:bg-white/10 hover:text-white transition-all">
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
            opacity: 0.3;
            cursor: pointer;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</x-app-layout>