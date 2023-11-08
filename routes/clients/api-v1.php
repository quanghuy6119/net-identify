<?php

use App\Http\Controllers\Api\Client\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['client_credentials', 'json.response']], function (){
    Route::prefix('/users')->name('.users')->group(function (){
        Route::get('', [UserController::class, 'get'])->name('.get');
    }); 
});
