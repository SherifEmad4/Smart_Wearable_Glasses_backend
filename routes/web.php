<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin-home',[App\Http\Controllers\HomeController::class , 'adminHome'])->name('admin-home')->middleware('isAdmin');

// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// // Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('register', [RegisterController::class, 'register']);
