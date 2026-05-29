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
                <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">@lang('messages.borrowing_receipt_header')</h2>
                <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">@lang('messages.borrowing_confirmation_subtitle')</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div id="receipt-card" class="bg-[#062C2C] p-16 rounded-[4rem] border border-white/5 shadow-[0_50px_100px_rgba(0,0,0,0.3)] relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/5 rounded-full blur-[80px]"></div>
                
                <div class="relative space-y-12">
                    <!-- Header Bukti -->
                    <div class="flex justify-between items-start border-b border-white/5 pb-12">
                        <div>
                            <h3 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">@lang('messages.receipt_number_label'): #{{ str_pad($borrowing->id, 8, '0', STR_PAD_LEFT) }}</h3>
                            <p class="text-[#B8860B] font-bold text-xs uppercase tracking-[0.3em] mt-3">@lang('messages.digital_library_system')</p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-2 bg-[#B8860B] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-[#B8860B]/20">
                                {{-- Display translated status --}}
                                @if($borrowing->status === 'borrowed')
                                    @lang('messages.receipt_status_borrowed')
                                @elseif($borrowing->status === 'overdue')
                                    @lang('messages.receipt_status_overdue')
                                @elseif($borrowing->status === 'returned')
                                    @lang('messages.receipt_status_returned')
                                @else
                                    {{ strtoupper($borrowing->status) }} {{-- Fallback if status is not translated --}}
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Detail Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em] mb-4">@lang('messages.borrower_info_title')</h4>
                                <p class="text-xl font-bold text-white uppercase">{{ $borrowing->user->name }}</p>
                                <p class="text-white/40 text-sm mt-1">{{ $borrowing->user->email }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em] mb-4">@lang('messages.book_info_title')</h4>
                                <p class="text-xl font-bold text-white uppercase">{{ $borrowing->book->title }}</p>
                                <p class="text-[#B8860B] font-bold text-xs uppercase tracking-[0.2em] mt-1">{{ $borrowing->book->author }}</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em] mb-4">@lang('messages.transaction_date_title')</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-white/40 text-xs uppercase">@lang('messages.borrow_date_receipt_label')</span>
                                        <span class="text-white font-bold text-xs">{{ $borrowing->borrow_date->format('d F Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-white/40 text-xs uppercase">@lang('messages.due_date_receipt_label')</span>
                                        <span class="text-rose-400 font-black text-xs">{{ $borrowing->due_date->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-white/5 rounded-3xl border border-white/5">
                                <p class="text-[10px] text-white/30 italic leading-relaxed">@lang('messages.loan_rule_fine_info')</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer / Print Action -->
                    <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row gap-6">
                        <button onclick="window.print()" class="flex-1 py-6 bg-[#B8860B] text-white font-black text-[10px] uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl active:scale-95 transition-all hover:bg-[#8B6508] flex items-center justify-center gap-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            @lang('messages.print_receipt_button')
                        </button>
                        <a href="{{ route('borrowings.index') }}" class="flex-1 py-6 bg-white/5 text-white/40 font-black text-center text-[9px] uppercase tracking-[0.4em] rounded-[2rem] hover:bg-white/10 hover:text-white transition-all flex items-center justify-center">
                            @lang('messages.back_to_borrowings_list')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; background: white !important; }
            #receipt-card, #receipt-card * { visibility: visible; }
            #receipt-card { 
                position: absolute; left: 0; top: 0; width: 100%; 
                background: white !important; color: black !important;
                border: none !important; box-shadow: none !important;
                padding: 0 !important;
            }
            .glass-card { background: white !important; backdrop-filter: none !important; }
            .text-white { color: black !important; }
            .text-indigo-400 { color: #4f46e5 !important; }
            .text-indigo-300\/40 { color: #6366f1 !important; opacity: 1 !important; }
            .text-white\/40 { color: #6b7280 !important; }
            .text-pink-400 { color: #db2777 !important; }
            .bg-indigo-600 { background: #4f46e5 !important; color: white !important; }
            .border-white\/10 { border-color: #e5e7eb !important; }
            button, a { display: none !important; }
        }
    </style>
</x-app-layout>
