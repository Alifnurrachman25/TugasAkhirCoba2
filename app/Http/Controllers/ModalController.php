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
        $startOfMonth = now()->startOfMonth();
        $startOfWeek = now()->startOfWeek();

        return view('modal.index', [
            'modalHariIni' => Modal::whereDate('created_at', $today)->get(),
            'modalMingguIni' => Modal::whereBetween('created_at', [$startOfWeek, now()])->get(),
            'modalBulanIni' => Modal::whereBetween('created_at', [$startOfMonth, now()])->get(),
            // 'modalSemua' => Modal::orderBy('created_at', 'desc')->get(),
            'totalHariIni' => Modal::whereDate('created_at', $today)->sum('jumlah'),
            'totalMingguIni' => Modal::whereBetween('created_at', [$startOfWeek, now()])->sum('jumlah'),
            'totalBulanIni' => Modal::whereBetween('created_at', [$startOfMonth, now()])->sum('jumlah'),
            // 'totalSemua' => Modal::sum('jumlah'),
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

        return redirect()->route('modal.index')->with('success', 'Data modal berhasil ditambahkan.');
    }
    public function create()
    {
        return view('modal.create');
    }

    public function edit($id)
    {
        $modal = Modal::findOrFail($id);
        return view('modal.edit', compact('modal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required',
        ]);

        // Bersihkan format "Rp" dan titik dari jumlah
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);

        $modal = Modal::findOrFail($id);
        $modal->update([
            'deskripsi' => $request->deskripsi,
            'jumlah' => $jumlah,
        ]);

        return redirect()->route('modal.index')->with('success', 'Modal berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $modal = Modal::findOrFail($id);
        $modal->delete();

        return redirect()->route('modal.index')->with('success', 'Modal berhasil dihapus.');
    }

}
