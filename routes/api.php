<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

     
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('blogs', BlogController::class)->except([
    'update'
]);;
    Route::post('blogs/{id}', [BlogController::class, 'update']);
    Route::get('logout', [AuthController::class, 'singout']);
});