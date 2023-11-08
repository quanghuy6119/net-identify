<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Login;

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

Route::get("", Login::class)->name('login');