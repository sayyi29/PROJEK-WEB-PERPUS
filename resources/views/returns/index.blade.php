<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Asset Restitution</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Return Records</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Logged recovery of digital and physical volumes</p>
            </div>
        </div>

        <!-- Return Table Container -->
        <div class="bg-[#062C2C] rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/5">
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Restitutor</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest">Asset Details</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest text-center">Protocol Date</th>
                            <th class="px-8 py-6 text-[10px] font-black text-white/70 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($returns as $return)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-black text-xs border border-white/10">
                                            {{ substr($return->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-white uppercase">{{ $return->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-white uppercase tracking-tight">{{ $return->book->title }}</p>
                                    <p class="text-[9px] font-black text-[#B8860B] uppercase tracking-tighter mt-0.5">{{ $return->book->category->name }}</p>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <p class="text-[10px] font-bold text-white">{{ $return->return_date->format('d M Y') }}</p>
                                    <p class="text-[8px] text-white/40 font-bold uppercase tracking-widest">RESTORED</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border bg-white/5 text-white/30 border-white/10">
                                            Completed
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-xs font-black text-white/20 uppercase tracking-widest">No recovery protocols logged</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($returns->hasPages())
                <div class="px-8 py-6 bg-white/5 border-t border-white/5">
                    {{ $returns->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>