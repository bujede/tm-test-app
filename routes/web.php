<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/social-sign-in', [ AuthController::class, 'makeSocialSignIn'])->name('social-sign-in');
Route::get('/handle-social-sign-in', [ AuthController::class, 'handleMakeSocialSignIn']);


Route::middleware('auth')->group(function(){
    Route::get('/home', [ AuthController::class, 'home'])->name('home');
    Route::get('/logout', [ AuthController::class, 'logout'])->name('logout');
});