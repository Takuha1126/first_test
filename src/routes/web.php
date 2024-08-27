<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WorkController::class, 'index'])->name('home');
    Route::post('/start',[WorkController::class,'startWork'])->name('work.start');
    Route::post('/end',[WorkController::class,'endWork'])->name('work.end');
    Route::post('/restIn',[WorkController::class,'breakIn'])->name('break.in');
    Route::post('/restOut',[WorkController::class,'breakOut'])->name('break.out');
    Route::get('/attendance', [ContentController::class, 'attendance'])->name('attendance');
    Route::get('/day', [DayController::class, 'showDay'])->name('day.show');
    Route::get('/day/{date}', [DayController::class, 'redirectToAttendance']);
    Route::get('/user',[UserController::class, 'index'])->name('users.index');
    Route::get('/user/{user}',[UserController::class, 'show'])->name('users.show');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes();




