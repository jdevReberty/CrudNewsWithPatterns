<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NewsController;
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

/* ----------------- rotas para cadastro de usuário e login ----------------- */
Route::middleware(['out'])->group(function () {
    Route::prefix('/login')->group(function() {
        Route::get('/', [AuthController::class, 'index'])->name('login.index');
        Route::post('/access', [AuthController::class, 'authenticate'])->name('login.auth');
    });
});

/* ------------------------ rotas internas do sistema ----------------------- */
Route::middleware(['auth'])->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/', function () {
//     return view('pages.table_list');
// });
