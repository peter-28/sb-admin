<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\MasterData\CategoriesController;
use App\Http\Controllers\Admin\MasterData\FasilitasController;
use App\Http\Controllers\Admin\MasterData\KostController;
use App\Http\Controllers\Admin\MasterData\PenyewaanController;
use App\Models\Customer;
use App\Models\Kost;

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
    return view('welcome', [
        'kosts'=> Kost::all()
    ]);
});


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/action', [LoginController::class, 'login'])->name('login.action');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/action', [RegisterController::class, 'register'])->name('register.action');
});

Route::middleware(['auth'])->group(function () {
    #logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    #dashboard
    #master-data
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('master-data')->group(function () {
            Route::prefix('categories')->group(function () {
                Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
                Route::post('/save', [CategoriesController::class, 'saveCategories'])->name('categories.save');
            });
            Route::prefix('fasilitas')->group(function () {
                Route::get('/', [FasilitasController::class, 'index'])->name('fasilitas.index');
                Route::post('/save', [FasilitasController::class, 'saveFasilitas'])->name('fasilitas.save');
            });
            Route::prefix('kost')->group(function () {
                Route::get('/', [KostController::class, 'index'])->name('kost.index');
                Route::post('/save', [KostController::class, 'saveKost'])->name('kost.save');
            });

            Route::prefix('penyewaan')->group(function () {
                Route::get('/', [PenyewaanController::class, 'index'])->name('penyewaan.index');
                Route::get('/detail-sewa/{id}', [PenyewaanController::class, 'detailSewa'])->name('penyewaan.detaiSewa');
            });
        });
    });
});
