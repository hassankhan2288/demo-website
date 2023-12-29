<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\OAuthClient;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:branch');
        generateBreadcrumb();
    }

    public function index(){

        $user = Auth::user();

        return view('pos.partials.account.index', compact('user'));
    }

    public function saveSettings(Request $request){
        $request->validate([
            "name"  => "required|string|max:25|min:3",
            "phone"  => "nullable|numeric|digits:11",
            "address"  => "nullable|max:500",
        ]);
        if($request->password){
           $request->validate([
                "password"  => "required|string|min:8|confirmed",
            ]); 
        }
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['success'=>true]);
    }
    public function logoutBranch(Request $request)
{
    //dd($current_uri = request()->segments());

    Auth::logout();

    $request->session()->flush();

    $request->session()->regenerate();

    return redirect()->route( 'pos.login' );
}

}