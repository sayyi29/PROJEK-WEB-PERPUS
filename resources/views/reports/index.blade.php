<x-app-layout>
    <div class="space-y-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Centralized Reporting</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Operational Reports</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Generate high-fidelity audit and analytical documentation</p>
            </div>
        </div>

        <!-- Filter & Action Card -->
        <div class="premium-card p-10 rounded-[3rem]">
            <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-[#062C2C] uppercase tracking-widest ml-2">From Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-[#FDFCF9] border border-[#E8E4D9] rounded-2xl px-6 py-4 text-[#062C2C] focus:ring-[#B8860B] focus:border-[#B8860B]">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-[#062C2C] uppercase tracking-widest ml-2">To Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-[#FDFCF9] border border-[#E8E4D9] rounded-2xl px-6 py-4 text-[#062C2C] focus:ring-[#B8860B] focus:border-[#B8860B]">
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-8 py-4 bg-slate-50 text-[#062C2C] font-black text-[10px] uppercase tracking-widest rounded-2xl border border-[#E8E4D9] hover:bg-slate-100 transition-all">
                        Refresh Matrix
                    </button>
                    <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 px-8 py-4 bg-[#B8860B] text-white font-black text-[10px] uppercase tracking-widest rounded-2xl shadow-xl shadow-[#B8860B]/20 hover:bg-[#966F09] transition-all flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Recent Activity Matrix -->
        <div class="premium-card p-12 rounded-[3rem]">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-lg font-black text-[#062C2C] tracking-tight uppercase tracking-widest">Recent Activity Matrix</h3>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em]">Audit Trail Enabled</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#F9F7F2]">
                            <th class="px-6 py-4 text-[#B8860B] font-black text-xs uppercase tracking-widest">Borrower</th>
                            <th class="px-6 py-4 text-[#B8860B] font-black text-xs uppercase tracking-widest">Asset</th>
                            <th class="px-6 py-4 text-[#B8860B] font-black text-xs uppercase tracking-widest text-center">Protocol Date</th>
                            <th class="px-6 py-4 text-[#B8860B] font-black text-xs uppercase tracking-widest text-center">Current Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FDFCF9]">
                        @foreach($recentBorrowings as $b)
                            <tr class="group hover:bg-[#FDFCF9] transition-colors duration-300">
                                <td class="px-6 py-6">
                                    <p class="text-sm font-black text-[#062C2C] uppercase">{{ $b->user->name }}</p>
                                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">AUTH-KEY: {{ substr(md5($b->user->id), 0, 8) }}</p>
                                </td>
                                <td class="px-6 py-6">
                                    <p class="text-sm font-bold text-[#062C2C] truncate w-64">{{ $b->book->title }}</p>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <p class="text-[10px] font-bold text-[#062C2C]">{{ $b->borrow_date->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex justify-center">
                                        <span class="px-3 py-1 rounded text-[8px] font-black uppercase tracking-widest {{ $b->status == 'borrowed' ? 'text-amber-600 bg-amber-50' : 'text-emerald-600 bg-emerald-50' }}">
                                            {{ $b->status }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
