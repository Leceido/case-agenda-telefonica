<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ContactController;

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

//middleware('auth:api')->

Route::middleware('auth:api')->get('/', [ContactController::class, 'index'])->name('home');

Route::middleware('auth:api')->get('contact/', [ContactController::class, 'index'])->name('contact.home');

Route::middleware('auth:api')->get('contact/{id}', [ContactController::class, 'show'])->name('contact.show');

Route::middleware('auth:api')->post('contact/', [ContactController::class, 'store'])->name('contact.create');

Route::middleware('auth:api')->put('contact/{id}', [ContactController::class, 'update'])->name('contact.update');

Route::middleware('auth:api')->delete('contact/{id}', [ContactController::class, 'destroy'])->name('contact.delete');

Route::post('/user/login', [LoginController::class, 'login'])->name('user.login');

Route::middleware('auth:api')->post('/user/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::post('/user/register', [LoginController::class, 'register'])->name('user.register');
