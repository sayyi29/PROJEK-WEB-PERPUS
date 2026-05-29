<div x-data="{ open: false }" class="relative">
    <!-- Notification Bell Button -->
    <button @click="open = !open" 
            class="relative w-12 h-12 rounded-2xl bg-[#062C2C] shadow-sm border border-white/5 flex items-center justify-center text-white/40 hover:text-white transition-all group">
        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-3 right-3 w-4 h-4 bg-[#B8860B] rounded-full border-2 border-[#062C2C] flex items-center justify-center">
                <span class="text-[8px] font-black text-white">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open" 
         @click.away="open = false" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="absolute right-0 mt-4 w-96 bg-[#062C2C] rounded-3xl border border-white/10 shadow-[0_30px_60px_rgba(0,0,0,0.3)] overflow-hidden z-[100]">
        
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-white uppercase">Activity Logs</h3>
                <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest mt-0.5">Audit Trail & System Monitoring</p>
            </div>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[9px] font-black text-[#B8860B] hover:text-[#B8860B]/80 uppercase tracking-widest transition-colors">
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="max-h-[400px] overflow-y-auto">
            @forelse($logs as $log)
                <div wire:click="markAsRead({{ $log->id }})" class="p-5 hover:bg-white/5 transition-colors border-b border-white/5 last:border-0 cursor-pointer group relative">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            @php
                                $iconColor = match($log->action) {
                                    'create' => 'bg-emerald-500/10 text-emerald-500',
                                    'update' => 'bg-blue-500/10 text-blue-500',
                                    'delete' => 'bg-rose-500/10 text-rose-500',
                                    default => 'bg-white/10 text-white/50'
                                };
                            @endphp
                            <div class="w-10 h-10 rounded-xl {{ $iconColor }} flex items-center justify-center">
                                @if($log->action == 'create')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                @elseif($log->action == 'update')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                @elseif($log->action == 'delete')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-[10px] font-black text-white uppercase tracking-tight truncate">
                                    {{ $log->user->name ?? 'System' }} 
                                    <span class="text-white/20 mx-1">•</span> 
                                    <span class="text-{{ $log->action == 'delete' ? 'rose' : ($log->action == 'update' ? 'blue' : 'emerald') }}-500">{{ $log->action }}</span>
                                </p>
                                <p class="text-[8px] font-bold text-white/30 uppercase tracking-widest">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-xs text-white/50 leading-relaxed line-clamp-2">
                                {{ $log->description }}
                            </p>
                        </div>
                        @if(!$log->is_read)
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <div class="w-2 h-2 bg-[#B8860B] rounded-full shadow-[0_0_10px_rgba(184,134,11,0.5)]"></div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-20 flex flex-col items-center justify-center opacity-20">
                    <svg class="w-12 h-12 mb-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <p class="text-[10px] font-black uppercase tracking-widest text-white">No Recent Activity</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('admin.logs') }}" class="block p-5 bg-white/5 hover:bg-white/10 text-center text-[10px] font-black text-white uppercase tracking-widest transition-colors">
            View All Audit Logs
        </a>
    </div>
</div>
