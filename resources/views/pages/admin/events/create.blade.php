@extends('layouts.admin_layouts')

@section('content')
            <div class="container mx-auto px-4 py-6 max-w-4xl">

                <div class="mb-4">
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-ghost gap-2 text-gray-600 hover:text-gray-900">
                        Kembali ke Manajemen Event
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-xl font-bold text-gray-800">Tambah Event Baru</h2>
                        <p class="text-sm text-gray-500">Silakan isi data event beserta detail tiket yang akan dijual.</p>
                    </div>

                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>error</strong>
                    <ul class="list-disc pl-5 mt-2 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Judul Event</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('judul') border-red-500 @enderror">
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Kategori</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <select name="kategori_id" required
                        class="select select-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('kategori_id') border-red-500 @enderror">
                        <option value="" disabled selected>Pilih Kategori Event</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Durasi Event (Jam)</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="number" name="durasi_jam" value="{{ old('durasi_jam') }}" min="1" placeholder="Contoh: 2" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('durasi_jam') border-red-500 @enderror">
                    @error('durasi_jam')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Lokasi</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('lokasi') border-red-500 @enderror">
                    @error('lokasi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Tanggal & Waktu</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="tanggal_waktu" value="{{ old('tanggal_waktu') }}" required
                        class="input input-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('tanggal_waktu') border-red-500 @enderror">
                    @error('tanggal_waktu')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Gambar Banner Event</span>
                        <span class="text-gray-400 font-normal text-xs">(Maksimal 2MB, Opsional)</span>
                    </label>
                    <input type="file" name="gambar" id="gambarInput" accept="image/*"
                        class="file-input file-input-bordered w-full rounded-md text-sm border-gray-300 @error('gambar') border-red-500 @enderror">
                    @error('gambar')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    <div id="imagePreviewContainer" class="hidden mt-3 p-2 border border-gray-200 rounded-lg max-w-xs bg-gray-50">
                        <p class="text-xs text-gray-500 mb-1 font-medium">Pratinjau Gambar:</p>
                        <img id="imagePreview" src="#" alt="Preview Banner" class="w-full h-40 object-cover rounded-md shadow-inner">
                    </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Deskripsi Event</span>
                        <span class="text-error text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="4" required
                        class="textarea textarea-bordered w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <hr class="border-gray-200 my-6">

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Detail Tiket</h3>
                        <p class="text-xs text-gray-500">Tentukan tipe, harga, dan alokasi kuota tiket untuk event ini.</p>
                    </div>
                    <button type="button" id="btnTambahTiket" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 shadow-sm">
                        + Tambah Tiket
                    </button>
                </div>

                <div id="ticketCardsContainer" class="space-y-4">
                    </div>
                @error('tikets')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('events.index') }}" class="px-5 py-2.5 rounded border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow">
                    Simpan Event
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
        
        let ticketCount = 0;

        // validasi awal agar script tidak crash jika elemen repeater tidak ditemukan
        if (!container || !btnTambahTiket) return;

        function addTicketCard() {
            ticketCount++;
            
            const cardHtml = `
                <div class="ticket-card bg-gray-50 p-5 rounded-2xl border border-gray-200 relative shadow-inner space-y-4" data-id="${ticketCount}">
                    <div class="flex justify-between items-center border-b border-gray-150 pb-2.5">
                        <span class="text-sm font-bold text-gray-700 ticket-title">Tiket #${ticketCount}</span>
                        <button type="button" class="btn-remove-ticket text-xs font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-lg transition duration-150">
                            Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tipe Tiket <span class="text-rose-500">*</span></label>
                            <select name="tikets[${ticketCount}][tipe]" required class="select select-bordered w-full rounded-xl border-gray-200 bg-white text-gray-800 text-sm px-3 py-2 h-10 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                                <option value="reguler">Reguler</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Harga (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="tikets[${ticketCount}][harga]" min="0" placeholder="0" required 
                                class="input input-bordered w-full rounded-xl border-gray-200 bg-white text-gray-800 text-sm px-3.5 py-2 h-10 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Stok Kuota <span class="text-rose-500">*</span></label>
                            <input type="number" name="tikets[${ticketCount}][stok]" min="0" placeholder="0" required 
                                class="input input-bordered w-full rounded-xl border-gray-200 bg-white text-gray-800 text-sm px-3.5 py-2 h-10 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', cardHtml);
            updateTicketNumbers();
        }

        function updateTicketNumbers() {
            const cards = container.querySelectorAll('.ticket-card');
            cards.forEach((card, idx) => {
                card.querySelector('.ticket-title').innerText = `Tiket #${idx + 1}`;
            });
            
            const removeButtons = container.querySelectorAll('.btn-remove-ticket');
            removeButtons.forEach(btn => {
                btn.style.display = cards.length === 1 ? 'none' : 'block';
            });
        }

        btnTambahTiket.addEventListener('click', addTicketCard);

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove-ticket')) {
                e.target.closest('.ticket-card').remove();
                updateTicketNumbers();
            }
        });

        // validasi aman untuk preview gambar agar tidak melempar eror null
        if (gambarInput && previewImg && previewContainer) {
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
        }

        // generate tiket pertama secara otomatis saat load awal
        addTicketCard();
    });
</script>
@endsection