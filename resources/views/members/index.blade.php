<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">Personnel Directory</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Data Members</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Digital credentials & membership authentication</p>
            </div>
            
            <button onclick="window.location.href='{{ route('members.create') }}'" class="px-8 py-4 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#062C2C]/20 hover:bg-[#041E1E] hover:scale-105 transition-all active:scale-95 flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Register Member
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="flex items-center gap-4">
             <a href="{{ route('members.index') }}" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('status') ? 'bg-[#062C2C] text-white shadow-lg' : 'bg-white text-slate-400 border border-[#E8E4D9] hover:border-[#B8860B]' }}">
                All Personnel
            </a>
            <a href="{{ route('members.index', ['status' => 'active']) }}" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'active' ? 'bg-[#062C2C] text-white shadow-lg' : 'bg-white text-slate-400 border border-[#E8E4D9] hover:border-[#B8860B]' }}">
                Active
            </a>
            <a href="{{ route('members.index', ['status' => 'pending_approval']) }}" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'pending_approval' ? 'bg-[#062C2C] text-white shadow-lg' : 'bg-white text-slate-400 border border-[#E8E4D9] hover:border-[#B8860B]' }}">
                Pending
            </a>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($members as $member)
                <div class="premium-card p-8 rounded-[2.5rem] relative overflow-hidden group">
                    <!-- Background Accent -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-[#062C2C]/5 rounded-full blur-2xl group-hover:bg-[#B8860B]/5 transition-colors"></div>

                    <div class="flex gap-6 relative">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-2xl border-2 border-[#E8E4D9] overflow-hidden group-hover:border-[#B8860B] transition-colors bg-slate-50">
                                @if($member->profile_photo_path)
                                    <img src="{{ asset('storage/' . $member->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[#062C2C] font-black text-xl">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-mono text-[9px] text-[#B8860B] font-bold uppercase tracking-tighter mb-1">ID-PRTCL: {{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    <h3 class="text-lg font-black text-[#062C2C] uppercase tracking-tight truncate leading-tight">{{ $member->name }}</h3>
                                </div>
                                @php
                                    $statusColor = match($member->status) {
                                        'active' => 'bg-emerald-500 shadow-emerald-500/50',
                                        'pending_approval' => 'bg-amber-500 shadow-amber-500/50',
                                        default => 'bg-slate-300 shadow-slate-300/50'
                                    };
                                @endphp
                                <div class="flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $statusColor }} shadow-lg animate-pulse"></div>
                                    <span class="text-[8px] font-black uppercase text-slate-400 tracking-widest">{{ $member->status }}</span>
                                </div>
                            </div>

                            <div class="mt-4 space-y-1.5">
                                <div class="flex items-center gap-2 text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-bold truncate">{{ $member->email }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span class="text-[10px] font-bold">{{ $member->phone ?? 'NO-TELEMETRY' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-8 pt-6 border-t border-[#F9F7F2] flex items-center justify-between">
                        <div class="flex gap-1">
                            <a href="{{ route('members.show', $member->id) }}" class="p-2 text-slate-400 hover:text-[#062C2C] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('members.edit', $member->id) }}" class="p-2 text-slate-400 hover:text-[#B8860B] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            @if($member->status == 'pending_approval')
                                <form action="{{ route('members.approve', $member->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[9px] font-black text-emerald-600 uppercase tracking-widest border border-emerald-100 px-3 py-1 rounded-lg hover:bg-emerald-50 transition-colors">
                                        Authorize
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('members.show', $member->id) }}" class="text-[9px] font-black text-[#062C2C] uppercase tracking-widest flex items-center gap-2 group-hover:underline">
                                Full Profile <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-10">
            {{ $members->links() }}
        </div>
    </div>
</x-app-layout>
