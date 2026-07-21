<div class="relative overflow-hidden bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 group transition-all duration-500 hover:shadow-slate-200">
    <!-- Subtle Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 opacity-90"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute -top-12 -right-12 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors"></div>
    <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-slate-700/20 rounded-full blur-3xl"></div>

    <div class="relative px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Brand & Scannable -->
        <div class="flex items-center gap-6">
            <div class="bg-white p-2 rounded-xl shadow-xl flex-shrink-0 group-hover:scale-105 transition-transform duration-500">
                {!! QrCode::size(55)->margin(1)->color(15, 23, 42)->generate(Auth::user()->email) !!}
            </div>
            
            <div class="space-y-1.5">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-black text-white tracking-tighter uppercase leading-none">
                        LUMINA <span class="text-amber-500">PRIME</span>
                    </h2>
                    <span class="px-2.5 py-1 bg-white/5 border border-white/10 text-white/60 text-[8px] font-black rounded-full uppercase tracking-[0.2em]">Verified Status</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Access Tier: Gold Member
                </p>
            </div>
        </div>

        <!-- User Identity Info -->
        <div class="flex items-center gap-5 md:border-l md:border-white/10 md:pl-6">
            <div class="text-right">
                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Official Member</p>
                <p class="text-base font-black text-white uppercase tracking-tight">{{ Auth::user()->name }}</p>
                <p class="text-[8px] font-medium text-slate-500 uppercase tracking-widest mt-1">ID: {{ substr(md5(Auth::user()->email), 0, 12) }}</p>
            </div>
            
            <div class="relative">
                <div class="h-11 w-11 rounded-2xl overflow-hidden border border-white/10 shadow-xl group-hover:border-amber-500/30 transition-all duration-500">
                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-800 flex items-center justify-center text-white font-black text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-amber-500 rounded-lg flex items-center justify-center border-2 border-slate-900">
                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>
