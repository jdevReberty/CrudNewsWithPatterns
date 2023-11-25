<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'index']);
Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/new_user', [UserController::class, 'create']);
Route::post('/new_user/store', [UserController::class, 'store']);


//rotas autenticadas
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('/')->group(function() {
        Route::get('home', [NewsController::class, 'index']);
        Route::get('news/create', [NewsController::class, 'create']);
        Route::post('news/store', [NewsController::class, 'store']);
        Route::get('news/view', [NewsController::class, 'view']);
        Route::post('news/update', [NewsController::class, 'update']);
        
        Route::prefix('user')->group(function() {
            Route::get('/get', [AuthController::class, 'getAuthUser']);
            Route::get('/profile', [UserController::class, 'profile']);
            Route::post('/profile/update', [UserController::class, 'update']);
        });
    });
    Route::get('/logout', [AuthController::class, 'logout']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
