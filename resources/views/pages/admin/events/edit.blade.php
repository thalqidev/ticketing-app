@extends('layouts.admin_layouts')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow" role="alert">
        <strong class="font-bold">eror nya ini bang : </strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mx-auto px-4 py-6 max-w-4xl">

    <div class="mb-4">
        <a href="{{ route('events.index') }}" class="btn btn-sm btn-ghost gap-2 text-gray-600 hover:text-gray-900">
            Kembali ke Manajemen Event
        </a>
    </div>

    @if($hasSales)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded shadow-sm text-yellow-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold text-sm">Peringatan:</span>
                <span class="text-sm ml-1">Event ini sudah memiliki penjualan tiket. Beberapa field mungkin tidak dapat diubah.</span>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Edit Data Event</h2>
            <p class="text-sm text-gray-500">Perbarui informasi event dan modifikasi kuota jenis tiket.</p>
        </div>

        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Judul Event</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $event->judul) }}" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Kategori</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <select name="kategori_id" required
                        class="select select-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $event->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Lokasi</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Tanggal & Waktu</span>
                        <span class="text-error text-red-500">*</span>
                        @if($hasSales)
                            <span class="text-xs text-amber-600 block font-normal mt-0.5">Kunci (Sudah Ada Tiket Terjual)</span>
                        @endif
                    </label>
                    <input type="datetime-local" name="tanggal_waktu" 
                        value="{{ old('tanggal_waktu', \Carbon\Carbon::parse($event->tanggal_waktu)->format('Y-m-d\TH:i')) }}" required
                        {{ $hasSales ? 'readonly' : '' }}
                        class="input input-bordered w-full rounded-md text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 {{ $hasSales ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '' }}">
                    @error('tanggal_waktu')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Durasi Event (Jam)</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="number" name="durasi_jam" value="{{ old('durasi_jam', $event->durasi_jam) }}" min="1" required
                        placeholder="Masukkan durasi dalam jam..."
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Gambar Banner Event</span>
                        <span class="text-gray-400 font-normal text-xs block mt-0.5">Hint: Kosongkan jika tidak ingin mengubah gambar</span>
                    </label>
                    
                    <div class="mb-3 p-2 border border-gray-200 rounded-lg max-w-xs bg-gray-50">
                        <p class="text-xs text-gray-400 mb-1 font-medium">Gambar Saat Ini:</p>
                        <img src="{{ Str::contains($event->gambar, 'events') ? asset('storage/' . $event->gambar) : asset('images/konser.jpg') }}" 
                             alt="Current Banner" class="w-full h-32 object-cover rounded-md shadow-sm">
                    </div>

                    <input type="file" name="gambar" id="gambarInput" accept="image/*"
                        class="file-input file-input-bordered w-full rounded-md text-sm border-gray-300">

                    <div id="imagePreviewContainer" class="hidden mt-3 p-2 border border-blue-200 rounded-lg max-w-xs bg-blue-50">
                        <p class="text-xs text-blue-600 mb-1 font-medium">Pratinjau Gambar Baru:</p>
                        <img id="imagePreview" src="#" alt="Preview New Banner" class="w-full h-32 object-cover rounded-md shadow-sm">
                    </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Deskripsi Event</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="4" required
                        class="textarea textarea-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                </div>

            </div>

            <hr class="border-gray-200 my-6">

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Detail Tiket</h3>
                        <p class="text-xs text-gray-500">Modifikasi atau tambahkan ragam jenis tiket baru.</p>
                    </div>
                    <button type="button" id="btnTambahTiket" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold py-2 px-4 rounded transition shadow-sm">
                        + Tambah Jenis Tiket Baru
                    </button>
                </div>

                <div id="ticketCardsContainer" class="space-y-4"></div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('events.index') }}" class="px-5 py-2.5 rounded border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow">
                    Perbarui Event
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('ticketCardsContainer');
        const btnTambahTiket = document.getElementById('btnTambahTiket');
        const gambarInput = document.getElementById('gambarInput');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImg = document.getElementById('imagePreview');
        
        const eventHasSales = @json($hasSales);
        const existingTickets = @json($event->tikets);
        
        let ticketCount = 0;

        // fungsi merender struktur Card Tiket 
        function renderTicketCard(ticket = null) {
            ticketCount++;
            
            const ticketId = ticket ? ticket.id : '';
            const ticketTipe = ticket ? ticket.tipe : 'reguler';
            const ticketHarga = ticket ? ticket.harga : 0;
            const ticketStok = ticket ? ticket.stok : 0;
            
            // periksa pembatasan: jika tiket lama dan event memiliki riwayat penjualan, kunci status hapus
            const isRestricted = (ticket && eventHasSales);

            const cardHtml = `
                <div class="ticket-card bg-gray-50 p-4 rounded-lg border border-gray-200 relative shadow-inner space-y-3" data-id="${ticketCount}">
                    <input type="hidden" name="tikets[${ticketCount}][id]" value="${ticketId}">

                    <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-700 ticket-title">Tiket #${ticketCount}</span>
                            ${isRestricted ? `<span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-full border border-amber-200">Sudah Terjual</span>` : ''}
                        </div>
                        
                        ${isRestricted ? '' : `
                            <button type="button" class="btn-remove-ticket text-xs text-red-500 hover:text-red-700 font-medium bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition">
                                Hapus
                            </button>
                        `}
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Tipe Tiket <span class="text-red-500">*</span></label>
                            <select name="tikets[${ticketCount}][tipe]" required class="select select-bordered w-full rounded border-gray-300 text-sm">
                                <option value="reguler" ${ticketTipe === 'reguler' ? 'selected' : ''}>Reguler</option>
                                <option value="premium" ${ticketTipe === 'premium' ? 'selected' : ''}>Premium</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="tikets[${ticketCount}][harga]" value="${ticketHarga}" min="0" required 
                                class="input input-bordered w-full rounded border-gray-300 text-sm">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Stok Kuota <span class="text-red-500">*</span></label>
                            <input type="number" name="tikets[${ticketCount}][stok]" value="${ticketStok}" min="0" required 
                                class="input input-bordered w-full rounded border-gray-300 text-sm">
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', cardHtml);
            updateTicketSequencing();
        }

        function updateTicketSequencing() {
            const cards = container.querySelectorAll('.ticket-card');
            cards.forEach((card, idx) => {
                card.querySelector('.ticket-title').innerText = `Tiket #${idx + 1}`;
            });

            // proteksi fallback jika belum ada penjualan namun baris tinggal satu, sembunyikan hapus
            const removeButtons = container.querySelectorAll('.btn-remove-ticket');
            if (cards.length === 1 && !eventHasSales) {
                removeButtons.forEach(btn => btn.style.display = 'none');
            } else {
                removeButtons.forEach(btn => btn.style.display = 'block');
            }
        }

        if (existingTickets && existingTickets.length > 0) {
            existingTickets.forEach(ticket => renderTicketCard(ticket));
        } else {
            renderTicketCard();
        }

        btnTambahTiket.addEventListener('click', () => renderTicketCard());

        // event delegation untuk eksekusi remove ticket card
        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove-ticket')) {
                const card = e.target.closest('.ticket-card');
                card.remove();
                updateTicketSequencing();
            }
        });

        gambarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.setAttribute('src', e.target.result);
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    });
</script>
@endsection