<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Modal;

class ModalController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek();
        $startOfMonth = now()->startOfMonth();

        return view('modal.index', [
            'modalHariIni' => Modal::whereDate('created_at', $today)->get(),
            'modalMingguIni' => Modal::whereBetween('created_at', [$startOfWeek, now()])->get(),
            'modalBulanIni' => Modal::whereBetween('created_at', [$startOfMonth, now()])->get(),
            'totalHariIni' => Modal::whereDate('created_at', $today)->sum('jumlah'),
            'totalMingguIni' => Modal::whereBetween('created_at', [$startOfWeek, now()])->sum('jumlah'),
            'totalBulanIni' => Modal::whereBetween('created_at', [$startOfMonth, now()])->sum('jumlah'),
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required'
        ]);

        // Hilangkan karakter non-angka dari input 'jumlah' (misal: "Rp 10.000" → 10000)
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);

        // Simpan ke database
        Modal::create([
            'deskripsi' => $request->deskripsi,
            'jumlah' => (int) $jumlah,
        ]);

        return redirect()->back()->with('success', 'Data modal berhasil ditambahkan.');
    }
}
