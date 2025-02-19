<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/client', [\App\Http\Controllers\RoleController::class, 'client'])->name('client');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('appointment/view/{appointment}', [AdminController::class, 'show'])
    ->name('appointment.show');




