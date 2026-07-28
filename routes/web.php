<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('simple_welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kasirs', KasirController::class)->except(['show']);
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('promotions', PromotionController::class)->except(['show']);
    Route::resource('bookings', BookingController::class)->except(['show']);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\KasirController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [App\Http\Controllers\KasirController::class, 'create'])->name('transactions');
    Route::post('/transactions', [App\Http\Controllers\KasirController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/receipt', [App\Http\Controllers\KasirController::class, 'receipt'])->name('transactions.receipt');
    Route::post('/transactions/{transaction}/settle', [App\Http\Controllers\KasirController::class, 'settleTransaction'])->name('transactions.settle');
    Route::get('/customers/create', [App\Http\Controllers\KasirController::class, 'createCustomer'])->name('customers.create');
    Route::post('/customers', [App\Http\Controllers\KasirController::class, 'storeCustomer'])->name('customers.store');
    Route::get('/history', [App\Http\Controllers\KasirController::class, 'history'])->name('history');
    Route::get('/unpaid', [App\Http\Controllers\KasirController::class, 'unpaid'])->name('unpaid');
    Route::get('/queue', [App\Http\Controllers\KasirController::class, 'queue'])->name('queue');
    Route::get('/bookings', [App\Http\Controllers\KasirController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [App\Http\Controllers\KasirController::class, 'updateBookingStatus'])->name('bookings.status');
    Route::post('/bookings/{booking}/convert', [App\Http\Controllers\KasirController::class, 'convertBookingToTransaction'])->name('bookings.convert');
});
