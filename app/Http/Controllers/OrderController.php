<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->join('tikets', 'detail_orders.tiket_id', '=', 'tikets.id')
            ->where('orders.user_id', auth()->id())
            ->select(
                'orders.id as order_id',
                'orders.order_date',
                'orders.total_harga',
                'events.judul as event_judul',
                'events.gambar as event_gambar',
                'tikets.tipe as tiket_tipe',
                'detail_orders.jumlah'
            )
            ->orderBy('orders.order_date', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);

        if ($tiket->stok !== null && $tiket->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Waduh stok tiket tidak mencukupi, jir!');
        }

        DB::transaction(function () use ($tiket, $request) {
            $orderId = DB::table('orders')->insertGetId([
                'user_id'     => auth()->id(),
                'event_id'    => $tiket->event_id,
                'order_date'  => now(),
                'total_harga' => $tiket->harga * $request->jumlah,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            DB::table('detail_orders')->insert([
                'order_id'       => $orderId,
                'tiket_id'       => $tiket->id, 
                'jumlah'         => $request->jumlah,
                'subtotal_harga' => $tiket->harga * $request->jumlah,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            if ($tiket->stok !== null) {
                $tiket->decrement('stok', $request->jumlah);
            }
        });

        return redirect()->back()->with('success', 'Tiket berhasil dibeli! Transaksi tercatat aman di data orders & detail, jir.');
    }
    public function adminIndex()
    {
        // mengambil semua transaksi masuk dari seluruh user di database
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->join('tikets', 'detail_orders.tiket_id', '=', 'tikets.id')
            ->select(
                'orders.id as order_id',
                'orders.order_date',
                'orders.total_harga',
                'users.name as user_name',
                'users.email as user_email',
                'events.judul as event_judul',
                'tikets.tipe as tiket_tipe',
                'detail_orders.jumlah'
            )
            ->orderBy('orders.order_date', 'desc')
            ->get();

        return view('admin.transactions.index', compact('orders'));
    }
}