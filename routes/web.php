<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [\App\Http\Controllers\RoleController::class, 'admin'])->name('admin');
Route::get('/client', [\App\Http\Controllers\RoleController::class, 'client'])->name('client');
