@extends('layouts.admin_layouts')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="card bg-white shadow-md rounded-2xl border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h2 class="font-bold text-slate-800 text-lg">Daftar Transaksi Masuk</h2>
        <span class="badge badge-primary px-3 py-2 font-bold">{{ $orders->count() }} Order</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr class="bg-slate-50/20 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="py-4 pl-6 text-center">No</th>
                    <th class="py-4">Pembeli</th>
                    <th class="py-4">Nama Event</th>
                    <th class="py-4 text-center">Tipe Tiket</th>
                    <th class="py-4 text-center">Jumlah</th>
                    <th class="py-4 text-right">Total Harga</th>
                    <th class="py-4 pr-6">Tanggal Order</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $index => $order)
                    <tr class="hover:bg-slate-50/30 transition duration-150 align-middle">
                        <td class="py-4 pl-6 text-center text-slate-400 font-bold text-sm">{{ $index + 1 }}</td>
                        <td class="py-4">
                            <div class="font-bold text-slate-800">{{ $order->user_name }}</div>
                            <div class="text-xs text-slate-400">{{ $order->user_email }}</div>
                        </td>
                        <td class="py-4 font-semibold text-slate-700">{{ $order->event_judul }}</td>
                        <td class="py-4 text-center">
                            @php
                                $isVip = in_array(strtolower($order->tiket_tipe), ['vip', 'premium', 'vvip', 'gold']);
                            @endphp
                            <span class="badge {{ $isVip ? 'badge-warning' : 'badge-neutral' }} uppercase text-[10px] font-bold px-2 py-1">
                                {{ $order->tiket_tipe }}
                            </span>
                        </td>
                        <td class="py-4 text-center font-bold text-slate-600">{{ $order->jumlah }}x</td>
                        <td class="py-4 text-right font-black text-emerald-600 text-sm">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="py-4 pr-6 text-xs text-slate-500 font-medium">
                            {{ \Carbon\Carbon::parse($order->order_date)->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-400 font-medium">
                            Belum ada transaksi tiket masuk dari pembeli.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection