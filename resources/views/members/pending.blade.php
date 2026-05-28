<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('members.index') }}" 
               class="p-4 bg-white/5 rounded-[1.5rem] hover:bg-white/10 transition-all duration-300 text-indigo-400 border border-white/5 shadow-xl hover:scale-110 active:scale-95 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase leading-none mb-1">@lang('messages.member_approval_header')</h2>
                <p class="text-indigo-400 font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">@lang('messages.member_pending_list_subtitle')</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        @if(session('success'))
            <div class="mb-10 p-6 glass-card rounded-[2rem] border border-indigo-500/30 bg-indigo-500/10 text-white font-bold flex items-center gap-4 animate-bounce">
                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/40">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-10 p-6 glass-card rounded-[2rem] border border-red-500/30 bg-red-500/10 text-red-300 font-bold flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center shadow-lg shadow-red-500/40">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass-card p-12 rounded-[3rem] shadow-[0_50px_100px_rgba(0,0,0,0.3)] border border-white/5">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-2xl font-black text-white tracking-tight uppercase tracking-widest">@lang('messages.member_list')</h3>
                {{-- No create button needed here --}}
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="px-6 py-4 text-indigo-400 font-black text-xs uppercase tracking-widest">@lang('messages.member_name_header')</th>
                            <th class="px-6 py-4 text-indigo-400 font-black text-xs uppercase tracking-widest">@lang('messages.email_address')</th>
                            <th class="px-6 py-4 text-indigo-400 font-black text-xs uppercase tracking-widest">@lang('messages.member_phone_header')</th>
                            <th class="px-6 py-4 text-indigo-400 font-black text-xs uppercase tracking-widest">@lang('messages.member_status_header')</th>
                            <th class="px-6 py-4 text-indigo-400 font-black text-xs uppercase tracking-widest">@lang('messages.actions')</th>
                        </tr>
                    </thead>
                    <tbody class="text-white/80 divide-y divide-white/5">
                        @forelse($members as $member)
                        <tr class="group hover:bg-white/5 transition-colors duration-300">
                            <td class="px-6 py-6 text-sm font-medium">
                                {{ $member->name }}
                            </td>
                            <td class="px-6 py-6 text-sm">
                                {{ $member->email }}
                            </td>
                            <td class="px-6 py-6 text-sm">
                                {{ $member->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-6">
                                @if($member->status === 'pending_approval')
                                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-[10px] font-black uppercase tracking-widest border border-yellow-500/20">@lang('messages.pending_approval')</span>
                                @elseif($member->status === 'active')
                                    <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-500/20">@lang('messages.active')</span>
                                @else {{-- inactive --}}
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-500/20">@lang('messages.inactive')</span>
                                @endif
                            </td>
                            <td class="px-6 py-6 flex items-center gap-3">
                                {{-- Approve Button --}}
                                <form action="{{ route('members.approve', $member->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="p-2.5 bg-white/5 rounded-xl hover:bg-white/10 transition-all text-green-400 border border-white/5 flex items-center justify-center w-max">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @lang('messages.approve_member_button')
                                    </button>
                                </form>
                                {{-- Reject Button --}}
                                <form action="{{ route('members.reject', $member->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="p-2.5 bg-white/5 rounded-xl hover:bg-white/10 transition-all text-red-400 border border-white/5 flex items-center justify-center w-max">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        @lang('messages.reject_member_button')
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center font-black text-indigo-200/20 uppercase tracking-[0.4em] text-xs italic">
                                @lang('messages.member_pending_empty')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-10">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</x-app-layout>