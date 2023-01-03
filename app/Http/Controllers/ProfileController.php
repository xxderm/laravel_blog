<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class ProfileController extends Controller
{
    public function Show()
    {
        return view('profile', ['user' => Auth::user()]);    
    }
}
