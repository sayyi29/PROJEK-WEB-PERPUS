<div class="space-y-6">
    <!-- Section: Top Command Center (Stats) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="premium-card p-4 rounded-[1.5rem] flex items-center gap-4 group">
            <div class="w-12 h-12 bg-[#062C2C]/5 rounded-2xl flex items-center justify-center text-[#062C2C] group-hover:bg-[#062C2C] group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ __('messages.total_collection') }}</p>
                <h4 class="text-xl font-black text-[#062C2C]">{{ number_format($stats['total_books']) }}</h4>
            </div>
        </div>

        <div class="premium-card p-4 rounded-[1.5rem] flex items-center gap-4 group">
            <div class="w-12 h-12 bg-[#062C2C]/5 rounded-2xl flex items-center justify-center text-[#062C2C] group-hover:bg-[#062C2C] group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ __('messages.total_members') }}</p>
                <h4 class="text-xl font-black text-[#062C2C]">{{ number_format($stats['total_members']) }}</h4>
            </div>
        </div>

        <div class="premium-card p-4 rounded-[1.5rem] flex items-center gap-4 group">
            <div class="w-12 h-12 bg-[#062C2C]/5 rounded-2xl flex items-center justify-center text-[#062C2C] group-hover:bg-[#062C2C] group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ __('messages.active_borrowing') }}</p>
                <h4 class="text-xl font-black text-[#062C2C]">{{ number_format($stats['total_borrowed']) }}</h4>
            </div>
        </div>

        <div class="premium-card p-4 rounded-[1.5rem] flex items-center gap-4 group">
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-900 group-hover:bg-rose-900 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ __('messages.overdue') }}</p>
                <h4 class="text-xl font-black text-rose-900">{{ number_format($stats['total_overdue']) }}</h4>
            </div>
        </div>
    </div>

    <!-- Analytics & Trends -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 premium-card p-6 rounded-[2rem]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-black text-[#062C2C] uppercase tracking-tight">{{ __('messages.borrowing_trends') }}</h3>
            </div>
            <div class="h-[180px]">
                <canvas id="borrowingChart"></canvas>
            </div>
        </div>

        <div class="premium-card p-6 rounded-[2rem]">
            <h3 class="text-sm font-black text-[#062C2C] uppercase tracking-tight mb-4 text-center">{{ __('messages.category') }} Distribution</h3>
            <div class="h-[180px] flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Section: Recent Inventory -->
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-extrabold text-[#062C2C] tracking-tight uppercase">Recent Inventory</h3>
            <a href="{{ route('books.index') }}" class="text-[9px] font-black text-[#B8860B] uppercase tracking-widest hover:underline flex items-center gap-1">
                View All <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            @foreach($books->take(6) as $book)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden shadow-lg transition-all duration-300 group-hover:-translate-y-1 border border-slate-50">
                        <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover">
                    </div>
                    <div class="mt-2">
                        <h4 class="font-black text-[#062C2C] truncate text-[9px] uppercase tracking-tight">{{ $book->title }}</h4>
                        <p class="text-[8px] font-bold text-slate-400 mt-0.5 uppercase tracking-widest">{{ Str::limit($book->author, 20) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxBorrow = document.getElementById('borrowingChart').getContext('2d');
    new Chart(ctxBorrow, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Peminjaman',
                data: {!! json_encode($data) !!},
                borderColor: '#062C2C',
                backgroundColor: 'rgba(6, 44, 44, 0.05)',
                fill: true,
                tension: 0.4,
                borderWidth: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryData) !!},
                backgroundColor: ['#062C2C', '#4F7942', '#8B4513', '#B8860B', '#704214'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '80%' }
    });
</script>
@endpush

