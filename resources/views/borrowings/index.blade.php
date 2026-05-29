<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Circulation Desk</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Borrowing Records</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Active transaction monitoring & asset tracking</p>
            </div>
            
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('petugas'))
                <button onclick="window.location.href='{{ route('borrowings.create') }}'" class="px-8 py-4 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#062C2C]/20 hover:bg-[#041E1E] hover:scale-105 transition-all active:scale-95 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Transaction
                </button>
            @endif
        </div>

        <!-- Transaction Table Container -->
        <div class="bg-[#062C2C] rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/5">
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Borrower Protocol</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Asset Details</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Timeline</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-black text-xs border border-white/10">
                                            {{ substr($borrowing->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-white uppercase">{{ $borrowing->user->name }}</p>
                                            <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest">UID: {{ str_pad($borrowing->user->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-white uppercase tracking-tight">{{ $borrowing->book->title }}</p>
                                    <p class="text-[9px] font-black text-[#B8860B] uppercase tracking-tighter mt-0.5">{{ $borrowing->book->category->name }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                            <p class="text-[10px] font-bold text-white/80">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                            <p class="text-[10px] font-bold text-rose-300 uppercase tracking-tighter">Due: {{ $borrowing->due_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusStyle = match($borrowing->status) {
                                            'borrowed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'overdue' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'returned' => 'bg-white/5 text-white/30 border-white/10',
                                            default => 'bg-white/5 text-white/30'
                                        };
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $statusStyle }}">
                                        {{ $borrowing->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($borrowings->hasPages())
                <div class="px-8 py-6 bg-white/5 border-t border-white/5">
                    {{ $borrowings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
