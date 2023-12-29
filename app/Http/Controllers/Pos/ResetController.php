<?php

namespace App\Http\Controllers\Pos;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ResetController extends Controller
{
    public function posresetForm(){
        if(\Auth::guard('branch')->check()){
            return view('home');
        }
        return view('auth.passwords.email');
    }

    public function posresetLink(Request $request){
        // dd($request);
        $request->validate(['email' => 'required|email']);
 
        $status = \Illuminate\Support\Facades\Password::broker('branches')->sendResetLink(
            $request->only('email')
        );
    
        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function posResetPassUser(Request $request){
        // dd($request);
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
     
        $status = \Illuminate\Support\Facades\Password::broker('branches')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Branch $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('pos.login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}
