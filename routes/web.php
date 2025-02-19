<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\AuthController;

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

//Auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.proses');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.proses');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

//Siswa
Route::resource('siswa', SiswaController::class);
Route::get('/siswa/dataTable', [SiswaController::class,'getDataTable'])->name('siswa.getDataTable');

//Kota
Route::resource('kota', KotaController::class);
Route::get('/kota/dataTable', [KotaController::class,'getDataTable'])->name('kota.getDataTable');