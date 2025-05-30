<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\GenSettingsController;
use App\Http\Controllers\NisController;
use App\Models\Tiket;
use App\Models\Control;
use App\Http\Controllers\MerchController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('landing'));

Route::get('/eticket/{id}', [TiketController::class, 'show'])->name('eticket.show');

Route::get('/vote', function () {
    $control = Control::where('isvoteactive', true)->first();
    return $control ? view('vote.index') : view('vote.closed');
})->name('vote');
Route::post('/submit-vote', [VoteController::class, 'submitVote'])->name('vote.submit');

Route::get('/failed', fn() => view('payment.failed'))->name('failed');

Route::get('/merch', function () {
    $control = Control::where('ismerchactive', true)->first();
    return $control ? view('merch.pesan') : redirect()->route('failed');
})->name('merch');

/*
|--------------------------------------------------------------------------
| Merch Routes
|--------------------------------------------------------------------------
*/

Route::post('/beli-merch', [MerchController::class, 'beli'])->name('merch.beli');




/*
|--------------------------------------------------------------------------
| Authenticated User Routes/Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard.dashboard'))->name('dashboard');
    Route::get('/dashboard/scan', fn() => view('dashboard.scan'))->name('dashboard.scan');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // General Settings
    Route::get('/dashboard/control', [GenSettingsController::class, 'edit'])->name('dashboard.control');
    Route::put('/dashboard/control/{id}', [GenSettingsController::class, 'update'])->name('dashboard.control.update');

    // Tiket Management
    Route::get('/dashboard/tiket', function () {
        $data = Tiket::orderBy('created_at', 'desc')->paginate(request('perPage', 10));
        return view('dashboard.tiket', compact('data'));
    })->name('dashboard.tiket');

    Route::prefix('/dashboard/tiket')->name('tiket.')->group(function () {
        Route::post('/{id}/verifikasi', [TiketController::class, 'verifikasi'])->name('verifikasi');
        Route::get('/create', [TiketController::class, 'create'])->name('create');
        Route::post('/store', [TiketController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TiketController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [TiketController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [TiketController::class, 'destroy'])->name('destroy');
    });

    // Siswa Management
    Route::prefix('/dashboard/siswa')->name('dashboard.siswa')->group(function () {
        Route::get('/', [NisController::class, 'index']);
        Route::post('/store', [NisController::class, 'store'])->name('.store');
        Route::post('/{id}/update', [NisController::class, 'update'])->name('.update');
        Route::delete('/{id}/delete', [NisController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
        // Halaman daftar merch
        Route::get('/merch', [MerchController::class, 'index'])->name('merch.index');
    
        // Edit merch
        Route::get('/merch/{id}/edit', [MerchController::class, 'edit'])->name('merch.edit');
    
        // Update merch
        Route::put('/merch/{id}', [MerchController::class, 'update'])->name('merch.update');
    
        // Hapus merch
        Route::delete('/merch/{id}', [MerchController::class, 'destroy'])->name('merch.destroy');
    
        // Verifikasi pembayaran
        Route::post('/merch/{id}/verify', [MerchController::class, 'verifyPayment'])->name('merch.verif');

        // Pickup Merch
        Route::post('/merch/{id}/pickup', [MerchController::class, 'pickup'])->name('merch.pickup');

        // Manage
        Route::get('/merch-manage', [MerchController::class, 'manage'])->name('merch.manage');
    });

    // Vote Management
    Route::get('/dashboard/vote', [VoteController::class, 'dashboard'])->name('dashboard.vote');

});

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/

Route::middleware('payment')->prefix('payment')->name('payment.')->group(function () {
    Route::match(['get', 'post'], '/detail', [PayController::class, 'initPayment'])->name('init');
    Route::match(['get', 'post'], '/process', [PayController::class, 'processPayment'])->name('process');
    Route::match(['get', 'post'], '/upload', [PayController::class, 'uploadbukti'])->name('upload');
});

Route::get('/guest-registration', function () {
    $control = Control::where('isguestactive', true)->first();
    return $control ? view('payment.guest-registration') : redirect()->route('failed');
})->name('guest-registration');

Route::match(['get', 'post'], '/tamu-beli', [PayController::class, 'tamubeli'])->name('tamubeli');

Route::get('/pesan', function () {
    $control = Control::where('is_active', true)->first();
    return $control ? view('payment.pesan') : redirect()->route('failed');
})->name('pesan');

Route::get('/payment/afterpay', fn() => view('payment.success'))->name('success');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze/Fortify/etc.)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
