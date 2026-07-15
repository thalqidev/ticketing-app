@extends('layouts.admin_layouts')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight">Manajemen Event</h1>
            <p class="text-xs text-gray-400 mt-0.5">Kelola seluruh jadwal, kategori, lokasi, dan status event aktif.</p>
        </div>
        <a href="{{ route('events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-3 px-5 rounded-xl transition shadow-md shadow-blue-600/15 active:scale-[0.98]">
            + Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium shadow-sm flex items-center">
            <span> {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium shadow-sm flex items-center">
            <span> {{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white p-5 rounded-2xl shadow-sm mb-6 border border-gray-100">
        <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Cari Event</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul atau lokasi..." 
                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-gray-800 text-sm px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition">
            </div>

            @php
                $kategoris = \App\Models\Kategori::all();
            @endphp
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kategori</label>
                <select name="kategori_id" class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-gray-800 text-sm px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Urutan Tanggal</label>
                <select name="sort" class="w-full rounded-xl border-gray-200 bg-gray-50/50 text-gray-800 text-sm px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition">
                    <option value="asc" {{ request('sort', 'asc') == 'asc' ? 'selected' : '' }}>Terdekat</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold py-3 px-4 rounded-xl transition active:scale-[0.97] shadow-sm">
                    Filter
                </button>
                <a href="{{ route('events.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-center text-xs font-bold py-3 px-4 rounded-xl transition active:scale-[0.97]">
                    Reset
                </a>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left text-sm border-collapse">
                <thead class="bg-gray-50 text-gray-400 font-bold uppercase tracking-wider text-[11px] border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 w-28 text-center">Gambar</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4 w-32">Kategori</th>
                        <th class="px-6 py-4 w-48">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 w-28 text-center">Status</th>
                        <th class="px-6 py-4 w-48 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                    @forelse($events as $event)
                        @php
                            $waktuEvent = \Carbon\Carbon::parse($event->tanggal_waktu);
                            
                            if ($waktuEvent->isFuture()) {
                                $status = 'Upcoming';
                                $badgeClass = 'bg-blue-50 text-blue-700 border-blue-100';
                            } elseif (isset($event->durasi_jam) && $waktuEvent->copy()->addHours($event->durasi_jam)->isFuture()) {
                                $status = 'Ongoing';
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                            } elseif ($waktuEvent->isToday()) {
                                $status = 'Ongoing';
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                            } else {
                                $status = 'Completed';
                                $badgeClass = 'bg-gray-50 text-gray-500 border-gray-200';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-block w-14 h-14 rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                                    <img src="{{ Str::contains($event->gambar, 'events') ? asset('storage/' . $event->gambar) : asset('images/konser.jpg') }}" 
                                         alt="Thumbnail" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800 max-w-[200px] truncate">{{ $event->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md">
                                    {{ $event->kategori->nama ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                <span class="block text-gray-800 font-bold">{{ \Carbon\Carbon::parse($event->tanggal_waktu)->format('d M Y, H:i') }} WIB</span>
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ $event->durasi_jam ?? 0 }} Jam Lamanya</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-[150px] truncate">{{ $event->lokasi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border rounded-full shadow-sm {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                <div class="flex justify-center items-center gap-1.5">
                                    <a href="{{ route('events.show', $event->id) }}" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white font-bold px-3 py-1.5 rounded-lg transition duration-150">
                                        View
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white font-bold px-3 py-1.5 rounded-lg transition duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Semua tiket terkait juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white font-bold px-3 py-1.5 rounded-lg transition duration-150">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                                Tidak ada data event yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($events->hasPages())
        <div class="mt-6 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            {{ $events->appends(request()->except('page'))->links() }}
        </div>
    @endif

</div>
@endsection