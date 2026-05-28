<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Financial Penalties</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Fine Records</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Revenue tracking & debt reconciliation</p>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="px-6 py-4 bg-[#062C2C] rounded-2xl shadow-xl">
                    <p class="text-[8px] font-black text-[#B8860B] uppercase tracking-widest mb-1">Outstanding Total</p>
                    <h4 class="text-xl font-black text-white">Rp {{ number_format($fines->where('status', 'unpaid')->sum('amount')) }}</h4>
                </div>
            </div>
        </div>

        <!-- Fines Table Container -->
        <div class="premium-card rounded-[2.5rem] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FDFCF9] border-b border-[#E8E4D9]">
                            <th class="px-8 py-6 text-[10px] font-black text-[#062C2C] uppercase tracking-widest">Debtor</th>
                            <th class="px-8 py-6 text-[10px] font-black text-[#062C2C] uppercase tracking-widest">Protocol Detail</th>
                            <th class="px-8 py-6 text-[10px] font-black text-[#062C2C] uppercase tracking-widest">Penalty Amount</th>
                            <th class="px-8 py-6 text-[10px] font-black text-[#062C2C] uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F9F7F2]">
                        @forelse($fines as $fine)
                            <tr class="hover:bg-[#FDFCF9] transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#062C2C] font-black text-xs border border-[#E8E4D9]">
                                            {{ substr($fine->borrowing->user->name, 0, 1) }}
                                        </div>
                                        <p class="text-sm font-black text-[#062C2C] uppercase">{{ $fine->borrowing->user->name }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-[#062C2C]">{{ $fine->borrowing->book->title }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">LATENCY: {{ $fine->borrowing->return_date->diffInDays($fine->borrowing->due_date) }} DAYS</p>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-base font-black text-[#B8860B]">Rp {{ number_format($fine->amount) }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        @php
                                            $statusStyle = match($fine->status) {
                                                'unpaid' => 'bg-rose-50 text-rose-900 border-rose-100',
                                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                default => 'bg-slate-50 text-slate-400'
                                            };
                                        @endphp
                                        <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $statusStyle }}">
                                            {{ $fine->status }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-xs font-black text-slate-300 uppercase tracking-widest">Financial logs are clear</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
