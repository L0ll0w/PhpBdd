<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function admin()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/client');
        }
        return view('admin');
    }

    public function client()
    {
        return view('client');
    }
}
