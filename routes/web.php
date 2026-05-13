<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PPDB Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PendaftaranController::class, 'index'])
    ->name('ppdb.index');

Route::post('/', [PendaftaranController::class, 'store'])
    ->name('ppdb.store');

/**
 * DECOMPRESS FILE HUFFMAN
 */
Route::get(
    '/ppdb/decompress/{id}',
    [PendaftaranController::class, 'decompress']
)->name('ppdb.decompress');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    /**
     * LOGIN
     */
    Route::get('/login', [AdminController::class, 'login'])
        ->name('login');

    Route::post('/login', [AdminController::class, 'doLogin']);

    /**
     * DASHBOARD
     */
    Route::get('/', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    /**
     * PENDAFTAR
     */
    Route::get('/pendaftar', [AdminController::class, 'pendaftar'])
        ->name('pendaftar');

    Route::get('/pendaftar/{id}', [AdminController::class, 'show'])
        ->name('pendaftar.show');

    /**
     * UPDATE STATUS
     */
    Route::patch(
        '/pendaftar/{id}/status',
        [AdminController::class, 'updateStatus']
    )->name('pendaftar.status');

    /**
     * LOGOUT
     */
    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout');
});