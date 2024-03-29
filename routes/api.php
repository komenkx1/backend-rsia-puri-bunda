<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::get('/dashboard/total-item', [DashboardController::class, 'totalPerItem']);
    Route::get('/dashboard/top-login-activity', [DashboardController::class, 'topLoginActivity']);
    Route::get('/dashboard/user-activity', [DashboardController::class, 'userActivity']);
    
    Route::apiResources([
        "unit" => UnitController::class,
        "jabatan" => JabatanController::class,
        "pegawai" => UserController::class,
    ]);
});


// Route::resource("unit", [UnitController::class])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
