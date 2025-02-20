<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\AppointmentsController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();




Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirige vers la page d'accueil après la déconnexion
})->name('logout');


// Tableau de bord utilisateur
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

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

Route::post('/admin/schedules/store', [SchedulesController::class, 'store'])
    ->name('admin.schedules.store');
