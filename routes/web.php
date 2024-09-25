<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [AppController::class, 'index'])->name('landpage');
Route::get('/admin/login', [AppController::class, 'loginForm'])->name('login');
Route::post('/admin/login', [UserController::class, 'login']);

Route::get('/admin/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');         

Route::middleware(['auth'])->prefix('admin')->group(function () 
{
    Route::get('/', [AppController::class, 'admin'])->name('admin');
    Route::resource('/usuarios', UserController::class);
    Route::resource('/citas', ServiceController::class);


    
});

