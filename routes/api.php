<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| Authenticated API Route
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Siswa API
|--------------------------------------------------------------------------
*/

Route::get('/cari-nama', [SiswaController::class, 'search'])->name('siswa.search');

/*
|--------------------------------------------------------------------------
| Tiket & Scan API
|--------------------------------------------------------------------------
*/

Route::get('/validasi-nis/{id}', [TiketController::class, 'validasiNIS'])->name('tiket.validasiNIS');
Route::post('/scan/manual-checkin', [TiketController::class, 'manualCheckin'])->name('scan.manual.checkin');
Route::post('/scan/validate', [TiketController::class, 'validateScan'])->name('scan.validate');
Route::get('/cari-buyer', [TiketController::class, 'caribuyer'])->name('tiket.caribuyer');
Route::get('/verif-beli', [SiswaController::class, 'verify'])->name('siswa.verify');
Route::post('/scan/confirm-payment', [TiketController::class, 'confirmFullPayment'])->name('scan.confirm-payment');

/*
|--------------------------------------------------------------------------
| Misc API
|--------------------------------------------------------------------------
*/

Route::get('/get-quote', [QuoteController::class, 'getQuote'])->name('quote.get');

Route::get('/get-candidates', [VoteController::class, 'candidates'])->name('vote.candidates');
