<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class CapitalTodayController extends Controller
{
     public function index()
    {
        $todayTransactions = Transaction::with(['transaction_details.menu'])
                                ->where('status', 'paid')
                                ->whereDate('created_at', Carbon::today())
                                ->get();

        $modalHariIni = 0;
        $keuntunganHariIni = 0;

        foreach ($todayTransactions as $transaksi) {
            foreach ($transaksi->transaction_details as $detail) {
                $menu = $detail->menu;

                $hargaModal = $menu->modal ?? 0;
                $hargaJual = $detail->price;
                $qty = $detail->qty;

                $modalHariIni += $hargaModal * $qty;
                $keuntunganHariIni += ($hargaJual - $hargaModal) * $qty;
            }
        }

        return view('capital.index', compact('modalHariIni', 'keuntunganHariIni', 'todayTransactions'));
    }
}
