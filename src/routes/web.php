<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/home', [WorkController::class, 'index'])->name('home');

    Route::post('/home',[WorkController::class,'create']);
    Route::post('/end',[WorkController::class,'store']);
    Route::post('/restIn',[WorkController::class,'breakIn']);
    Route::post('/restOut',[WorkController::class,'breakOut']);
    Route::get('/attendance', [ContentController::class, 'attendance'])->name('attendance');
    Route::post('/attendance',[ContentController::class,'store']);
    Route::get('/logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');
    Route::get('/day', [DayController::class, 'index'])->name('day');
    Route::get('/user',[UserController::class, 'index'])->name('users.index');
    Route::get('/user/{user}',[UserController::class, 'show'])->name('users.show');
});


Route::get('/login/{credentials}', [AuthenticatedSessionController::class,'login']);
Route::post('/login',[AuthenticatedSessionController::class,'store'])->name('login');
Route::get('/register',[RegisterUserController::class,'register'])->name('register');
Route::post('/register',[RegisterUserController::class,'create']);
Route::get('/logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');

Auth::routes(['verify' => true]);




