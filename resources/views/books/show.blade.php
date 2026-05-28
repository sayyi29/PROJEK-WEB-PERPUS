<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-6">
                <a href="{{ url()->previous() }}" 
                   class="p-4 bg-white rounded-[1.5rem] hover:bg-slate-50 transition-all duration-300 text-[#062C2C] border border-slate-100 shadow-xl hover:scale-110 active:scale-95 group">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-black text-4xl text-[#062C2C] tracking-tighter uppercase leading-none mb-1">Detail Buku</h2>
                    <p class="text-[#B8860B] font-bold text-[10px] tracking-[0.4em] uppercase opacity-70">Informasi Lengkap Koleksi</p>
                </div>
            </div>
            
            @auth
                <livewire:wishlist-button :bookId="$book->id" />
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div id="book-detail-card" class="bg-white p-16 rounded-[4rem] border border-slate-100 shadow-[0_50px_100px_rgba(6,44,44,0.1)] relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#062C2C]/5 rounded-full blur-[80px]"></div>
                
                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-16">
                    <!-- Book Cover -->
                    <div class="md:col-span-1 flex justify-center items-center">
                        <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-auto max-h-96 object-contain rounded-3xl shadow-xl border border-slate-50">
                    </div>

                    <!-- Book Details -->
                    <div class="md:col-span-2 space-y-10">
                        <div>
                            <h3 class="text-3xl font-black text-[#062C2C] tracking-tighter uppercase italic leading-none mb-4">{{ $book->title }}</h3>
                            <p class="text-[#B8860B] font-bold text-xs uppercase tracking-[0.3em]">{{ $book->author }}</p>
                            <p class="text-slate-400 text-sm mt-1">{{ $book->publisher }}, {{ $book->year }}</p>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-2">ISBN</h4>
                                    <p class="text-[#062C2C] font-bold text-base">{{ $book->isbn }}</p>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-2">Kategori</h4>
                                    <p class="text-[#062C2C] font-bold text-base">{{ $book->category->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-2">Stok Tersedia</h4>
                                <p class="text-{{ $book->stock > 0 ? 'emerald-600' : 'rose-900' }} font-black text-xl">{{ $book->stock }}</p>
                            </div>
                            @if ($book->description)
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-2">Deskripsi</h4>
                                    <p class="text-slate-600 text-sm leading-relaxed">{{ $book->description }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-6 pt-8 border-t border-slate-100">
                            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('petugas'))
                                <a href="{{ route('books.edit', $book->id) }}" class="px-8 py-4 bg-[#062C2C] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#062C2C]/30 hover:bg-[#041E1E] hover:scale-105 transition-all active:scale-95">
                                    Edit Buku
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-8 py-4 bg-rose-900 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-rose-900/30 hover:bg-rose-950 hover:scale-105 transition-all active:scale-95">
                                        Hapus Buku
                                    </button>
                                </form>
                            @endif
                            
                            {{-- Borrow Button (Conditionally shown) --}}
                            @if ($book->stock > 0 && Auth::user()->hasRole('anggota'))
                                <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}" class="px-8 py-4 bg-[#4F7942] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#4F7942]/30 hover:bg-[#3D5E33] hover:scale-105 transition-all active:scale-95">
                                    Pinjam Buku Ini
                                </a>
                            @endif

                            {{-- Reserve Button (Conditionally shown) --}}
                            <button id="reserve-book-btn" 
                                    class="px-8 py-4 bg-[#B8860B] text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-2xl shadow-[#B8860B]/30 hover:bg-[#966F09] hover:scale-105 transition-all active:scale-95"
                                    data-book-id="{{ $book->id }}"
                                    data-reserve-url="{{ route('books.reserve', $book->id) }}"
                                    data-check-availability-url="{{ route('books.check_availability', $book->id) }}"
                                    style="display: none;"> {{-- Initially hidden, shown by JS --}}
                                Reservasi Buku
                            </button>
                            
                            {{-- Availability Status Display --}}
                            <div id="availability-status" class="flex items-center px-8 py-4 bg-slate-50 text-slate-400 font-bold text-xs uppercase tracking-[0.4em] rounded-2xl border border-slate-100">
                                Memeriksa ketersediaan...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating & Reviews Section -->
            <div class="mt-16">
                <livewire:book-rating :bookId="$book->id" />
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; background: white !important; }
            #receipt-card, #receipt-card * { visibility: visible; }
            #receipt-card { 
                position: absolute; left: 0; top: 0; width: 100%; 
                background: white !important; color: black !important;
                border: none !important; box-shadow: none !important;
                padding: 0 !important;
            }
            .glass-card { background: white !important; backdrop-filter: none !important; }
            .text-white { color: black !important; }
            .text-indigo-400 { color: #4f46e5 !important; }
            .text-indigo-300\/40 { color: #6366f1 !important; opacity: 1 !important; }
            .text-white\/40 { color: #6b7280 !important; }
            .text-pink-400 { color: #db2777 !important; }
            .bg-indigo-600 { background: #4f46e5 !important; color: white !important; }
            .border-white\/10 { border-color: #e5e7eb !important; }
            button, a { display: none !important; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookId = document.querySelector('[data-book-id]').dataset.bookId;
            const reserveUrl = document.querySelector('#reserve-book-btn').dataset.reserveUrl;
            const checkAvailabilityUrl = document.querySelector('#reserve-book-btn').dataset.checkAvailabilityUrl;
            const availabilityStatusDiv = document.getElementById('availability-status');
            const reserveButton = document.getElementById('reserve-book-btn');
            const borrowButton = document.querySelector('a[href*="/borrowings/create"]'); // Find borrow button
            const currentStock = parseInt('{{ $book->stock }}'); // Get current stock from blade
            const isUserMember = {{ Auth::check() && Auth::user()->hasRole('anggota') ? 'true' : 'false' }};

            // Fetch availability status
            fetch(checkAvailabilityUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.is_available) {
                        availabilityStatusDiv.textContent = 'SIAP DIPINJAM';
                        availabilityStatusDiv.classList.remove('text-white/40', 'bg-white/5', 'border-white/5');
                        availabilityStatusDiv.classList.add('bg-green-500/20', 'text-green-400', 'border', 'border-green-500/20');
                        if (borrowButton) {
                           borrowButton.style.display = 'flex'; // Ensure borrow button is visible
                        }
                        reserveButton.style.display = 'none'; // Hide reserve button
                    } else {
                        availabilityStatusDiv.textContent = `TERSEDIA: ${data.stock} stok`;
                        availabilityStatusDiv.classList.remove('text-white/40', 'bg-white/5', 'border-white/5');
                        availabilityStatusDiv.classList.add('bg-amber-500/20', 'text-amber-400', 'border', 'border-amber-500/20');

                        if (data.pending_reservations > 0) {
                            availabilityStatusDiv.textContent += ` | Reservasi: ${data.pending_reservations} antrian`;
                        }

                        if (isUserMember && data.stock <= 0 && !data.is_borrowed && data.pending_reservations < 5) { // Example limit of 5 reservations
                            reserveButton.style.display = 'flex'; // Show reserve button if user is member, stock is 0, not borrowed, and reservation queue is not full
                            if (borrowButton) {
                                borrowButton.style.display = 'none'; // Hide borrow button
                            }
                        } else {
                            reserveButton.style.display = 'none'; // Hide reserve button
                            if (borrowButton && data.stock > 0) { // If still available to borrow (e.g. stock > 0 but no reservations)
                                borrowButton.style.display = 'flex';
                            } else if (borrowButton) { // If stock is 0 and not reservable
                                borrowButton.style.display = 'none';
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching availability:', error);
                    availabilityStatusDiv.textContent = 'Gagal memeriksa';
                    availabilityStatusDiv.classList.add('bg-red-500/20', 'text-red-400', 'border', 'border-red-500/20');
                    reserveButton.style.display = 'none';
                    if (borrowButton) {
                         borrowButton.style.display = 'none';
                    }
                });

            // Handle reserve button click
            reserveButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (!confirm('Apakah Anda yakin ingin mereservasi buku ini?')) {
                    return;
                }

                // Use fetch API to send POST request to reserveBook endpoint
                fetch(reserveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is sent
                    },
                    // No body needed for this POST request, as it's handled by controller logic based on authenticated user and book ID
                })
                .then(response => response.json()) // Assuming reserveBook returns JSON
                .then(data => {
                    if (data.ok) { // Assuming controller returns {ok: true, message: '...'} on success
                        alert(data.message || 'Reservasi berhasil!');
                        window.location.reload(); // Refresh page to update status
                    } else {
                        alert(data.message || 'Reservasi gagal. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error reserving book:', error);
                    alert('Terjadi kesalahan saat mencoba mereservasi buku. Silakan periksa konsol.');
                });
            });

            // Ensure borrow button is displayed correctly initially
            if (borrowButton) {
                if (currentStock > 0 && isUserMember && !reserveButton.style.display === 'flex') {
                    borrowButton.style.display = 'flex';
                } else if (!reserveButton.style.display === 'flex') {
                    borrowButton.style.display = 'none';
                }
            }
        });
    </script>
</x-app-layout>
