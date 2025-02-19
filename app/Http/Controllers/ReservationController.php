<?php

namespace App\Http\Controllers;

use App\Mail\RdvConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Appointments;
class ReservationController{
    public function reserver(Request $request)
    {
        /*
         * $rdv = Appointments::create([
            'patient_name' => $request->input('patient_name'),
            'email' => $request->input('email'),
            'date_time' => $request->input('date_time'),
        ]);
        */

        // Send the confirmation email
        Mail::to($rdv->email)->send(new RdvConfirmationMail($rdv));

        return response()->json(['message' => 'Réservation confirmée et email envoyé']);
    }
}
