<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CapitalTodayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModalController;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::resource('/menu', MenuController::class)->middleware('auth')->missing(fn () => redirect()->back());
Route::resource('/transaction', TransactionController::class)->middleware('auth')->missing(fn () => redirect()->back());
Route::post('/transaction/{transaction}/pay', [TransactionController::class, 'pay'])->name('transaction.pay');
Route::resource('/user', UserController::class)->middleware('auth')->missing(fn () => redirect()->back());
Route::post('/user/delete', [UserController::class, 'destroy'])->middleware('auth');
Route::get('/user/edit/{user}', function (User $user) {
    if (Auth::user()->level_id !== $user->level_id) {
        return redirect()->back();
    }
    return view('account.edit', [
        'user' => $user->with('level')->where('id', $user->id)->get()
    ]);
})->middleware('auth');
Route::post('/user/edit/{user}', [UserController::class, 'updateProfile'])->middleware('auth');

Route::get('/menus/shows', [MenuController::class, 'show']);

Route::get('/activityLog', [ActivityLogController::class, 'index']);

Route::get('/invoice/{transaction}', function (Transaction $transaction) {
    return View('transaction.invoice', [
        'data' => $transaction->with(['transaction_details', 'transaction_details.menu', 'user'])->where('id',$transaction->id)->get()
    ]);
});

// Route::middleware(['auth', 'can:manager'])->group(function () {
//     Route::get('/capital', [CapitalTodayController::class, 'index'])->name('capital');
// });


Route::get('/modal', [ModalController::class, 'index'])->name('modal.index');
Route::post('/modal', [ModalController::class, 'store'])->name('modal.store');
Route::get('/modal/create', [ModalController::class, 'create'])->name('modal.create');
Route::get('/modal/{id}/edit', [ModalController::class, 'edit'])->name('modal.edit');
Route::put('/modal/{id}', [ModalController::class, 'update'])->name('modal.update');
Route::delete('/modal/{id}', [ModalController::class, 'destroy'])->name('modal.destroy');
Route::post('/menu/update-order', [MenuController::class, 'updateOrder'])->name('menu.updateOrder');




Route::get('/report', [ReportController::class, 'index'])->middleware('auth');

