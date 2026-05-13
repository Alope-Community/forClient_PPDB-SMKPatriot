<?php

use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});


Route::get('/', [PendaftaranController::class, 'index'])->name('ppdb.index');
Route::post('/', [PendaftaranController::class, 'store'])->name('ppdb.store');