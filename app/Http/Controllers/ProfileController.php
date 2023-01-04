<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function Show()
    {
        return view('profile', ['user' => Auth::user()]);    
    }

    public function SendVerifyNotify(Request $req)
    {
        Auth::user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    public function Verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/profile');
    }

    public function PasswordSendReset(Request $request)
    {
        $credentials = ['email' => Auth::user()->email];
        $status = Password::sendResetLink($credentials);
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['message' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function PasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        return redirect()->route('/profile')->with('message', __($status));     
    }
}
