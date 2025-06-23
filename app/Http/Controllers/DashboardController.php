<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Modal;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

        //Jika ingin perbulan
        // $startOfMonth = now()->startOfMonth();
        // $endOfMonth = now()->endOfMonth();

        // $totalPayment = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_payment');
        // $totalModal = Modal::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('jumlah');

        $today = now()->toDateString();

        $totalPayment = Transaction::whereDate('created_at', $today)->sum('total_transaction');
        $totalModal = Modal::whereDate('created_at', $today)->sum('jumlah');

        return view('home', [
            "total_menus" => Menu::all()->count(),
            'total_sales' => Transaction::select(Transaction::raw('SUM(total_transaction) as total_sales'))->whereDate('created_at', NOW()->toDateString())->get(),
            // 'total_income' => Transaction::select(Transaction::raw('SUM(total_payment) as total_income'))->whereDate('created_at', NOW()->toDateString())->get(),
            // 'total_income' => Modal::select(Modal::raw('SUM(jumlah) as total_income'))->whereDate('created_at', NOW()->toDateString())->get(),
            'total_income' => $totalPayment - $totalModal,
            'invoice' => Transaction::select(Transaction::raw('COUNT(id) as total_invoice'))->whereDate('created_at', NOW()->toDateString())->get(),
            'cashier' => User::select(User::raw('COUNT(id) as cashier'))->where('level_id', 2)->get(),
            'admin' => User::select(User::raw('COUNT(id) as admin'))->where('level_id', 3)->get(),
            'manager' => User::select(User::raw('COUNT(id) as manager'))->where('level_id', 2)->get(),
            'total_user' => User::select(User::raw('COUNT(id) as total_user'))->get(),
            'total_paid' => Transaction::select(Transaction::raw('COUNT(id) as total_paid'))->where('status','paid')->get(),
            'total_unpaid' => Transaction::select(Transaction::raw('COUNT(id) as total_unpaid'))->where('status','unpaid')->get(),
            'tables' => Transaction::select(Transaction::raw('COUNT(no_table) as tables'))->where('status','unpaid')->get()
        ]);
    }
}
