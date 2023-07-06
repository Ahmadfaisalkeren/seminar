<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailSeminarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('krofil', [HomeController::class, 'profile'])->name('profile.index');
    Route::get('myseminar', [HomeController::class, 'mySeminar'])->name('myseminar.index');
    Route::patch('profile/{id}', [HomeController::class, 'editProfile'])->name('profile.update');
    Route::post('daftar', [HomeController::class, 'storeSeminar'])->name('daftar');
    Route::get('/check-registration/{id}', [HomeController::class, 'checkRegistration']);
    Route::patch('imagePayment/{id}', [HomeController::class, 'imagePayment'])->name('imagePayment');
    Route::get('invoice/{id}', [HomeController::class, 'invoice'])->name('invoice');
    Route::get('certificate/{id}', [HomeController::class, 'certificate'])->name('certificate');
    Route::get('buttonDate/{id}', [HomeController::class, 'buttonDate']);
    Route::get('seminar', [SeminarController::class, 'card'])->name('seminar.index');
});

Route::prefix('admin/')
    ->middleware(['auth', 'role:2'])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('seminar', SeminarController::class);
        Route::get('seminar/data/{seminar_id}', [SeminarController::class, 'getUserData'])->name('seminar.data');
        Route::get('seminar/detail/{id}', [DetailSeminarController::class, 'detail']);
        Route::post('seminar/approve/{id}', [SeminarController::class, 'approve'])->name('seminar.approve');
        Route::post('seminar/reject/{id}', [SeminarController::class, 'reject'])->name('seminar.reject');
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::get('semprul', [ProductController::class, 'shower']);
        Route::resource('pendaftaran', PendaftaranController::class);
    });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
