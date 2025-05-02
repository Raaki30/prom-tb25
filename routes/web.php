<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\GenSettingsController;
use App\Http\Controllers\NisController;
use App\Models\Tiket;
use App\Models\Control;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('landing'));

Route::get('/pesan', function () {
    $control = Control::where('is_active', true)->first();
    return $control ? view('payment.pesan') : redirect('/');
})->name('pesan');

Route::get('/payment/afterpay', fn() => view('payment.success'))->name('success');

Route::get('/eticket/{id}', [TiketController::class, 'show'])->name('eticket.show');

Route::get('/vote', fn() => view('forms.vote'))->name('vote');

Route::get('/guest-registration', function () {
    $control = Control::where('isguestactive', true)->first();
    return $control ? view('payment.guest-registration') : redirect('/');
})->name('guest-registration');

Route::match(['get', 'post'], '/tamu-beli', [PayController::class, 'tamubeli'])->name('tamubeli');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
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

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze/Fortify/etc.)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
