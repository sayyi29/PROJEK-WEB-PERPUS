<div class="space-y-12">
    <!-- Hero: Membership Card -->
    <section>
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-black text-[#062C2C] uppercase tracking-tighter">Your Digital Passport</h3>
            <span class="px-4 py-1.5 bg-[#B8860B] text-white text-[10px] font-black rounded-full uppercase tracking-widest animate-pulse">Prime Access</span>
        </div>
        @include('profile.partials.membership-card')
    </section>

    <!-- Personal Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="premium-card p-8 rounded-[2.5rem] group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Books in Hand</p>
            <h4 class="text-3xl font-black text-[#062C2C]">{{ $stats['borrowed'] }}</h4>
        </div>
        <div class="premium-card p-8 rounded-[2.5rem] group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Saved to Wishlist</p>
            <h4 class="text-3xl font-black text-[#062C2C]">{{ $stats['wishlist'] }}</h4>
        </div>
        <div class="premium-card p-8 rounded-[2.5rem] group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pending Fines</p>
            <h4 class="text-3xl font-black {{ $stats['fines'] > 0 ? 'text-rose-900' : 'text-[#062C2C]' }}">Rp {{ number_format($stats['fines']) }}</h4>
        </div>
        <div class="premium-card p-8 rounded-[2.5rem] group">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Loan Allowance</p>
            <h4 class="text-3xl font-black text-[#4F7942]">{{ $stats['loan_limit'] }} <span class="text-xs text-slate-400">Slots left</span></h4>
        </div>
    </div>

    <!-- Recommendations & Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Reading Timeline -->
        <div class="lg:col-span-2 premium-card p-10 rounded-[3rem]">
            <h3 class="text-lg font-black text-[#062C2C] uppercase tracking-tight mb-10">Reading Progress (Last 6 Months)</h3>
            <div class="h-[250px]">
                <canvas id="readingTimelineChart"></canvas>
            </div>
        </div>

        <!-- Reservations Status -->
        <div class="bg-[#062C2C] p-10 rounded-[3rem] text-white shadow-2xl shadow-[#062C2C]/20">
            <h3 class="text-lg font-black uppercase tracking-tight mb-8 text-[#B8860B]">Reservations</h3>
            @if($reservations->count() > 0)
                <div class="space-y-6">
                    @foreach($reservations as $res)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-14 bg-white/10 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $res->book->cover_image_url }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase truncate w-32">{{ $res->book->title }}</p>
                                <span class="text-[9px] font-bold text-[#B8860B] uppercase tracking-widest">In Queue...</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 opacity-40">
                    <p class="text-xs font-bold uppercase tracking-widest">No active reservations</p>
                </div>
            @endif
        </div>
    </div>

    <!-- For You Section -->
    <section class="space-y-8">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-black text-[#062C2C] uppercase tracking-tight">Smart Recommendations</h3>
            <a href="{{ route('books.index') }}" class="text-[10px] font-black text-[#B8860B] uppercase tracking-widest hover:underline flex items-center gap-2">
                View All <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
            @foreach($forYou as $book)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-3xl overflow-hidden shadow-xl transition-all duration-500 group-hover:-translate-y-3">
                        <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[9px] font-black text-[#062C2C] shadow-sm flex items-center gap-1">
                            ★ {{ number_format($book->ratings_avg_rating ?? 0, 1) }}
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="font-black text-[#062C2C] truncate text-[10px] uppercase tracking-tight">{{ $book->title }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="space-y-8">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-black text-[#062C2C] uppercase tracking-tight">New Arrivals</h3>
            <a href="{{ route('books.index') }}" class="text-[10px] font-black text-[#B8860B] uppercase tracking-widest hover:underline flex items-center gap-2">
                View All <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
            @foreach($newArrivals as $book)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-3xl overflow-hidden shadow-xl transition-all duration-500 group-hover:-translate-y-3 border border-slate-100">
                        <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover">
                    </div>
                    <div class="mt-4">
                        <h4 class="font-black text-[#062C2C] truncate text-[10px] uppercase tracking-tight">{{ $book->title }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxTimeline = document.getElementById('readingTimelineChart').getContext('2d');
    new Chart(ctxTimeline, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Books Completed',
                data: {!! json_encode($data) !!},
                backgroundColor: '#062C2C',
                borderRadius: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
