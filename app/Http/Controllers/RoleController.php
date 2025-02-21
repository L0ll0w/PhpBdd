<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Schedules;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function index()
    {
        // Récupérer les créneaux et rendez-vous réservés
        $schedules = Schedules::all();
        $appointments = Appointments::with('user')->get();

        return view('admin', compact('schedules', 'appointments'));
    }
    public function admin()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/client');
        }

        $appointments = \App\Models\Appointments::with('user')->get();

        return view('admin', compact('appointments'));
    }



    public function client()
    {
        return view('client');
    }
}


