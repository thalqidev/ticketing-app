<?php

namespace App\Http\Controllers;

use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Regular user dilarang masuk ke area Admin Panel!');
        }

        return view('dashboard', [
            'categories' => Kategori::all()
        ]);
    }
}