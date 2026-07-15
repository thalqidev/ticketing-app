<x-app-layout>
    <div class="bg-slate-50/50 min-h-[75vh] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-xs breadcrumbs text-slate-400 mb-2 pl-1">
                <ul>
                    <li><a href="{{ route('home') }}" class="hover:text-blue-900 transition-colors">Beranda</a></li>
                    <li class="text-slate-600 font-medium">Riwayat Transaksi</li>
                </ul>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                        <span class="p-2 bg-blue-50 text-blue-900 rounded-2xl shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-3-12h.008v.008H13.5V6Zm0 3h.008v.008H13.5V9Zm0 3h.008v.008H13.5v-.008Zm0 3h.008v.008H13.5v-.008Zm0 3h.008v.008H13.5v-.008Zm-9-12H4.5A1.5 1.5 0 0 0 3 7.5v3A1.5 1.5 0 0 0 4.5 12h.008M4.5 12a1.5 1.5 0 0 0 1.5 1.5v3A1.5 1.5 0 0 0 4.5 18H3" />
                            </svg>
                        </span>
                        Riwayat Pembelian Tiket
                    </h1>
                    <p class="text-sm text-slate-500 mt-2 pl-1.5">Pantau semua tiket event yang sudah berhasil kamu amankan.</p>
                </div>
            </div>

            @if($orders->isEmpty())
                <div class="card bg-white shadow-sm border border-slate-100 rounded-3xl py-16 px-4 text-center max-w-md mx-auto mt-8">
                    <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-3-12h.008v.008H13.5V6Zm0 3h.008v.008H13.5V9Zm0 3h.008v.008H13.5v-.008Zm0 3h.008v.008H13.5v-.008Zm0 3h.008v.008H13.5v-.008Zm-9-12H4.5A1.5 1.5 0 0 0 3 7.5v3A1.5 1.5 0 0 0 4.5 12h.008M4.5 12a1.5 1.5 0 0 0 1.5 1.5v3A1.5 1.5 0 0 0 4.5 18H3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Tiket</h3>
                    <p class="text-slate-500 text-sm mb-6 px-4">Kamu belum pernah memesan tiket. Yuk, cari event menarik sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary bg-blue-900 hover:bg-blue-950 border-none rounded-2xl px-8 shadow-md transition-all">
                        Eksplorasi Event
                    </a>
                </div>
            @else
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="table w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 text-slate-400 text-xs uppercase tracking-wider border-b border-slate-100">
                                    <th class="py-5 pl-8 text-center w-16">No</th>
                                    <th class="py-5">Poster</th>
                                    <th class="py-5">Nama Event</th>
                                    <th class="py-5">Tanggal Pembelian</th>
                                    <th class="py-5 text-center">Tipe Tiket</th>
                                    <th class="py-5 text-center">Jumlah</th>
                                    <th class="py-5 pr-8 text-right">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($orders as $index => $order)
                                    @php
                                        // Validasi URL gambar otomatis
                                        if ($order->event_gambar && filter_var($order->event_gambar, FILTER_VALIDATE_URL)) {
                                            $imageUrl = $order->event_gambar;
                                        } else {
                                            $imageName = (!empty($order->event_gambar) && file_exists(public_path('storage/' . $order->event_gambar))) ? $order->event_gambar : 'konser.jpg';
                                            $imageUrl = asset('storage/' . $imageName);
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50/40 transition-all duration-200 align-middle">
                                        
                                        <td class="py-5 pl-8 text-center text-slate-500 font-semibold text-sm">
                                            {{ $index + 1 }}
                                        </td>
                                        
                                        <td class="py-5">
                                            <div class="avatar">
                                                <div class="w-14 h-14 rounded-2xl shadow-xs ring-2 ring-slate-100 overflow-hidden">
                                                    <img src="{{ $imageUrl }}" alt="{{ $order->event_judul }}" class="object-cover w-full h-full" />
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="py-5">
                                            <div class="font-bold text-slate-800 text-base">
                                                {{ $order->event_judul }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1 font-medium">
                                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Transaksi Sukses
                                            </div>
                                        </td>
                                        
                                        <td class="py-5 text-sm text-slate-600 font-medium">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($order->order_date)->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                                            </div>
                                        </td>
                                        
                                        <td class="py-5 text-center">
                                            @php
                                                $isVip = in_array(strtolower($order->tiket_tipe), ['vip', 'premium', 'vvip', 'gold']);
                                                $badgeStyle = $isVip 
                                                    ? 'bg-amber-50 text-amber-700 border-amber-200/60' 
                                                    : 'bg-blue-50 text-blue-700 border-blue-100';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeStyle }} tracking-wider uppercase">
                                                {{ $order->tiket_tipe }}
                                            </span>
                                        </td>
                                        
                                        <td class="py-5 text-center">
                                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-xs">
                                                {{ $order->jumlah }}x
                                            </span>
                                        </td>
                                        
                                        <td class="py-5 pr-8 text-right font-black text-emerald-600 text-lg">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>