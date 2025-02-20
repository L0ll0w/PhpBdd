<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvConfirmationMail;

class MessageController extends Controller
{
    // Le formulaire du message
    public function formRdvConfirmationMail()
    {
        return view("forms.rdv-confirmation");
    }

    // Envoi du mail aux utilisateurs
    public function sendRdvConfirmationMail(Request $request)
    {

        #1. Validation de la requête
        $this->validate($request, ['message' => 'bail|required']);

        #2. Récupération des utilisateurs
        $users = User::all();

        #3. Envoi du mail
        Mail::to($users)->bcc("test918237465@gmail.com")
            ->queue(new RdvConfirmationMail($request->all()));

        return back()->withText("Message envoyé");
    }

}
