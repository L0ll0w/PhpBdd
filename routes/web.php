<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\AppointmentsController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Tableau de bord utilisateur
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes pour les rôles
Route::get('/admin', [RoleController::class, 'admin'])->name('admin');
Route::get('/client', [RoleController::class, 'client'])->name('client');

// Affichage des créneaux disponibles pour réservation
Route::get('/schedules', [SchedulesController::class, 'schedules'])->name('schedules');

// Routes pour les rendez-vous
Route::get('/appointments', [AppointmentsController::class, 'showAvailableAppointments'])
    ->name('appointments.showAvailableAppointments');

Route::post('/appointments/book', [AppointmentsController::class, 'bookAppointment'])
    ->name('appointments.book')
    ->middleware('auth'); // Réservation sécurisée (authentification requise)
