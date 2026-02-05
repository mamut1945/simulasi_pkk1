<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('pages.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::resource('inventaris', InventarisController::class);
Route::resource('peminjaman', PeminjamanController::class);

