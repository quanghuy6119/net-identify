<?php

use App\Http\Livewire\Auth\Authorize;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Home;

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

Route::get("/a", Authorize::class);

Route::middleware('guest')->group(function () {
    Route::get("/login", Login::class)->name('login');
});

Route::middleware(['auth.jwt'])->group(function () {
    Route::get("/", Home::class)->name('home');
    Route::get("/home", Home::class)->name('home');
});