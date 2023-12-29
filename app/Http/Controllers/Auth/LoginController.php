<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Jobs\VerificationEmail;
use Auth;
use App\Admin;
use App\User;
use App\Customer;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showAdminLoginForm()
    {
        //$this->createAdmin();
        return view('auth.login', ['url' => 'admin']);
    }

     public function showPosLoginForm()
    {
        //$this->createAdmin();
        return view('auth.login', ['url' => 'pos']);
    }

    public function showAppLoginForm()
    {
        //$this->createAdmin();
        //dd('ok');
        return view('auth.login', ['url' => 'app']);
    }

    public function showCustomerLoginForm()
    {
        //$this->createAdmin();
        //dd('ok');
        if(\Auth::guard('customer')->user()){
            return redirect()->route('home');
        }
        return view('frontend.login', ['url' => 'customer']);
    }
     public function adminLogin(Request $request)
    {

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('admin/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

     public function posLogin(Request $request)
    {

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('branch')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('branch/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function appLogin(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('company/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function customerLogin(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if(!$customer){
            return redirect()->route('customer.post.login')->withInput($request->only('email', 'remember'))->with('error','Invalid Login Credentails');
        }
        if($customer->email_verified_at == null){
            return redirect()->route('customer.post.login')->withInput($request->only('email', 'remember'))->with('error','Verify Email First');
        }

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            //dd(\Auth::guard('customer')->user()->name);
            return redirect()->intended('/');
        }
        return back()->withInput($request->only('email', 'remember'))->with('error','Invalid Login Credentails');
    }

    private function createAdmin(){
        $user =  \App\Admin::create([
            'name' => 'Admin',
            'email' => 'yasirnaeem@outlook.com',
            'password' => Hash::make('secure'),
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = Customer::where('email', $request->email)->first();

 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['errors'=>['invalid credential']], 422);
        }
        if($user){
            if(!$user->email_verified_at){
                return response()->json(['errors'=>['please verify your email address']], 422);
            }
        }

        if($user){
            $data['access_token'] = $user->createToken($user->email)->plainTextToken;
            $data['data'] = $user;
            return response()->json($data);
        }

    }

    public function signup(Request $request)
    {
        \Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = Customer::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'warehouse'=>$request->location,
            'address'=>$request->address,
            'phone_number'=>$request->phone_number,
            'postal_code'=>$request->postcode,
            'city'=>$request->city,
        ]);
        dispatch(new VerificationEmail($user));
        
        if($user){
            $data['access_token'] = $user->createToken($user->email)->plainTextToken;
            $data['data'] = $user;
            return response()->json($data);
        }

    }
}
