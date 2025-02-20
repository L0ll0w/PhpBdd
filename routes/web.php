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

//Route::get('/testmail', function() {
//    $message = 'Test mail';
//
//    Mail::to('test918237465@gmail.com')->send (new RdvConfirmationMail($message));
//});

Route::get("message", "MessageController@formRdvConfirmationMail");
Route::post("message", "MessageController@sendRdvConfirmationMail")->name('send.rdv.confirmation');
