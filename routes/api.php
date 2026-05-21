<?php
use App\Http\Controllers\Api\V1\AuthController ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// A simple test route
Route::get('/test', function () {
    return 'Api is working'  ;
});

Route::post('/register', [AuthController::class, 'register']); 

Route::post('/login', [AuthController::class, 'login']);

 Route::middleware('auth:sanctum')->group(function () {
     Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/user', function (Request $request) { return $request->user();
       }); 
       });