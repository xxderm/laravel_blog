<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function SignIn(Request $req)
    {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            return redirect()->intended('/profile');
        }
        return back()->withErrors([
            'title' => 'The provided credentials do not match our records.'
        ]);
    }

    public function SignUp(Request $req)
    {
        $user = User::create([
            'email' => $req->input('email'),
            'name' => $req->input('email'),
            'password' => bcrypt($req->input('password'))
        ]);
        Auth::loginUsingId($user->id);
        return redirect()->route('/profile');
    }

    public function LogOut(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }
}
