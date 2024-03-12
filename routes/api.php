<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

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
Route::post('register',[UsersController::class,'register']);
Route::post('login',[UsersController::class,'login']);
Route::post('logout',[UsersController::class,'logout'])
    ->middleware('auth:sanctum');

//Route::get('users', [UsersController::class, 'index'])->middleware('auth:sanctum');;


