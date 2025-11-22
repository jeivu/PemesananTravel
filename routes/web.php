<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Route Publik 
Route::get('/', function () {
    return view('welcome');
});

// Route Grup Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard-test', function () {
        return "Berhasil Login Admin!";
    });

    Route::resource('schedules', ScheduleController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Grup Penumpang
Route::middleware(['auth', 'role:penumpang'])->group(function () {

    Route::get('/travels', [BookingController::class, 'index'])->name('travels.index');
    Route::post('/travels/book', [BookingController::class, 'book'])->name('travels.book');

    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
    
    Route::get('/booking/{booking}/payment', [BookingController::class, 'paymentForm'])->name('booking.payment.form');
    Route::post('/booking/{booking}/confirm', [BookingController::class, 'confirmPayment'])->name('booking.payment.confirm');
    Route::get('/booking/{booking}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';