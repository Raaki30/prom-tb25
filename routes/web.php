<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;
use App\Http\Controllers\TiketController;
use App\Models\Tiket;
use App\Http\Controllers\GenSettingsController;
use App\Models\Control;
use App\Http\Controllers\NisController;

Route::get('/', function () {
    
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard/scan', function () {
        return view('dashboard.scan');
    })->name('dashboard.scan');


    

    Route::get('/dashboard/control', [GenSettingsController::class, 'edit'])->name('dashboard.control');
    Route::put('/dashboard/control/{id}', [GenSettingsController::class, 'update'])->name('dashboard.control.update');

    Route::get('/dashboard/tiket', function () {
        $data = Tiket::orderBy('created_at', 'desc')->paginate(request('perPage', 10));
        return view('dashboard.tiket', compact('data'));
    })->name('dashboard.tiket');
    
    Route::post('/dashboard/tiket/{id}/verifikasi', [TiketController::class, 'verifikasi'])->name('tiket.verifikasi');
    Route::get('/dashboard/tiket/create', [TiketController::class, 'create'])->name('tiket.create');
    Route::post('/dashboard/tiket/store', [TiketController::class, 'store'])->name('tiket.store');
    Route::get('/dashboard/tiket/{id}/edit', [TiketController::class, 'edit'])->name('tiket.edit');
    Route::put('/dashboard/tiket/{id}/update', [TiketController::class, 'update'])->name('tiket.update');
    Route::delete('/dashboard/tiket/{id}/destroy', [TiketController::class, 'destroy'])->name('tiket.destroy');

});



Route::middleware('payment')->group(function () {
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::post('/detail', [PayController::class, 'initPayment'])->name('init');
        Route::get('/detail', [PayController::class, 'initPayment'])->name('init');
        Route::post('/process', [PayController::class, 'processPayment'])->name('process');
        Route::get('/process', [PayController::class, 'processPayment'])->name('process');
        Route::post('/upload', [PayController::class, 'uploadbukti'])->name('upload');
        Route::get('/upload', [PayController::class, 'uploadbukti'])->name('upload');
    });
});


Route::get('/pesan', function () {
    $control = Control::where('is_active', true)->first();
    if ($control) {
        return view('payment.pesan');
    } else {
        return redirect('/');
    }
})->name('pesan');

Route::get('/payment/afterpay', function () {
    return view('payment.success');
})->name('success');

Route::get('/eticket/{id}', [TiketController::class, 'show'])->name('eticket.show');

Route::get('/vote', function () {
    return view('forms.vote');
})->name('vote');

require __DIR__.'/auth.php';

Route::get('/guest-registration', function () {
    return view('payment.guest-registration');
})->name('guest-registration');

Route::post('/tamu-beli', [PayController::class, 'tamubeli'])->name('tamubeli');
Route::get('/tamu-beli', [PayController::class, 'tamubeli'])->name('tamubeli');



Route::get('/dashboard/siswa', [NisController::class, 'index'])->name('dashboard.siswa');
Route::post('/dashboard/siswa/store', [NisController::class, 'store'])->name('dashboard.siswa.store');
Route::post('/dashboard/siswa/{id}/update', [NisController::class, 'update'])->name('dashboard.siswa.update');
Route::delete('/dashboard/siswa/{id}/delete', [NisController::class, 'destroy'])->name('dashboard.siswa.delete');