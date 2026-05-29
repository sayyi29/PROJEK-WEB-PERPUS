<x-app-layout>
    <div class="max-w-6xl mx-auto pb-20">
        <!-- Header Page -->
        <div class="mb-12">
            <h2 class="text-3xl font-extrabold tracking-tighter text-[#1A1A1A] uppercase">Activity Logs</h2>
            <p class="text-xs font-bold text-[#888888] uppercase tracking-[0.3em] mt-1">Audit trail & system monitoring</p>
        </div>

        <!-- Table Container -->
        <div class="bg-[#062C2C] rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/5">
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Timestamp</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">User</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Action</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($logs as $log)
                            <tr class="hover:bg-white/5 transition-colors duration-300">
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-white">{{ $log->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-white/40 font-medium uppercase mt-0.5">{{ $log->created_at->format('H:i:s') }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-black text-white">
                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-white/90">{{ $log->user->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $color = match($log->action) {
                                            'create' => 'text-[#4CAF50] bg-[#E8F5E9]',
                                            'update' => 'text-[#2196F3] bg-[#E3F2FD]',
                                            'delete' => 'text-[#F44336] bg-[#FFEBEE]',
                                            default => 'text-[#888888] bg-[#F5F5F0]'
                                        };
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $color }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm text-[#888888] leading-relaxed">{{ $log->description }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        <p class="text-xs font-black uppercase tracking-widest">No activities found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="px-8 py-6 bg-[#FAF9F6] border-t border-[#EFEFE9]">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
