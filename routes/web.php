<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NewsController;
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

/* ----------------- rotas para cadastro de usuário e login ----------------- */
Route::middleware(['out'])->group(function () {
    Route::prefix('/login')->group(function() {
        Route::get('/', [AuthController::class, 'index'])->name('login.index');
        Route::post('/access', [AuthController::class, 'authenticate'])->name('login.auth');
    });
    Route::prefix('/user')->group(function() {
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/register', [UserController::class, 'store'])->name('user.store');
    });
});

/* ------------------------ rotas internas do sistema ----------------------- */
Route::middleware(['auth'])->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('/news')->group(function() {
        Route::get('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        Route::get('/show/{id}', [NewsController::class, 'show'])->name('news.show');
        Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('/update/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::get('/delete/{id}', [NewsController::class, 'delete'])->name('news.delete');
    });
    Route::prefix('/user')->group(function() {
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('user.update');
    });
    Route::middleware(['admin'])->group(function () {
        Route::prefix('/user')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::get('/byadmin/create', [UserController::class, 'create'])->name('user.admin.create');
            Route::post('/byadmin/store', [UserController::class, 'store'])->name('user.admin.store');
            Route::get('/byadmin/delete/{user}', [UserController::class, 'delete'])->name('user.admin.delete');
        });
    });
}); 

// Route::get('/', function () {
//     return view('pages.table_list');
// });
