<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authentificate']);

Route::get('reviews', [\App\Http\Controllers\ReviewController::class, 'index'])->name('reviews');
Route::get('order/{id}', [OrderController::class, 'get'])->name('order.get');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('profile/{status?}{day?}', [ProfileController::class, 'index'])->name('profile');

    Route::post('reset-password', [ProfileController::class, 'password'])->name('reset-password');

    Route::post('order', [OrderController::class, 'store'])->name('order.store');

    Route::post('order-delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
});

Route::middleware('admin')->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

