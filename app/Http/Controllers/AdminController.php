<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\User;
use App\Policies\AppointmentsPolicy;

class AdminController extends Controller{

    public function showAppointments(){
        $appointments = Appointments::with('user')->get();
        return view('admin', compact('appointments'));
    }

    public function index(){
        $this->authorize('viewAny', Appointments::class);
        return view('admin', ['appointments' => Appointments::all()]);
    }

    public function deleteAppointment($id){
        $appointments = Appointments::find($id);
        if (!$appointments) {
            return redirect()->route('admin');
        }
        $this->authorize('delete', $appointments);
        $appointments->delete();
        return redirect()->route('admin');
    }
}
