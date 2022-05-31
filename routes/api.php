<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('barang', [BarangController::class, 'index']);
Route::get('barang/{id?}', [BarangController::class, 'edit']);
Route::post('barang', [BarangController::class, 'store']);
Route::put('barang', [BarangController::class, 'update']);
Route::delete('barang/{id?}', [BarangController::class, 'destroy']);

Route::post('user', [UserController::class, 'store']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('upload', [FileController::class, 'upload']);
Route::get('upload', [FileController::class, 'index']);