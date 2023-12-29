<?php

namespace App\Http\Controllers\Front;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\MSDynamic;
use App\OAuthClient;
use App\Customer;
use App\Jobs\DynamicsCreateUser;
use App\Jobs\VerificationEmail;
use App\Warehouse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered; // Added by Hassan
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB; // Added by Hassan
// use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
// use Illuminate\Support\Facades\Password;
// use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //   $this->middleware('auth:customer');
        generateBreadcrumb();
    }

    // public function index(){

    //     $user = Auth::user();

    //     return view('app.partials.account.index', compact('user'));
    // }

    
    // public function receipt(){

    //     $user = Auth::user();
    //     $receipts = $user->receipts()->get();

    //     $subscription = $user->subscription('default');


    //     return view('app.partials.account.receipt', compact('receipts', 'subscription'));
    // }

    // public function saveSettings(Request $request){
    //     $request->validate([
    //         "name"  => "required|string|max:25|min:3",
    //     ]);
    //     if($request->password){
    //        $request->validate([
    //             "password"  => "required|string|min:8|confirmed",
    //         ]); 
    //     }
    //     $user = Auth::user();
    //     $user->name = $request->name;
    //     if($request->password){
    //         $user->password = Hash::make($request->password);
    //     }
    //     $user->save();
    //     return response()->json(['success'=>true]);
    // }

    public function logoutCustomer (Request $request)
{
   // dd($current_uri = request()->segments());
//dd('ok');
    Auth::logout();

    $request->session()->flush();

    $request->session()->regenerate();

    return redirect()->route( 'customer.login' );
}
    public function showRegisterCustomerForm(Request $request){

        //dd(1);
        $warehouse = Warehouse::where('is_active',1)->get();
       return view('frontend.register',compact('warehouse')); 
    }

    public function registerCustomer(Request $request, MSDynamic $api)
    {
        
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email:rfc|max:255',
            // 'address'=>'required',
            'checkout_preference'=>'required|not_in:0',
            'phone_number' => 'required|min:11',
            'postcode' => 'required',
            'city' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'warehouse'=>'required|not_in:0',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->symbols()
            ],
            // 'password'=>'required|min:6|max:30|confirmed',
            'password_confirmation' =>'required|same:password'
        ]);
        $email = $request->email;
        $user_check = Customer::where('email', $email)->first();
        if($user_check){
            request()->session()->flash('email','Email taken, please try another');
            // return back()->with('email','Email taken, please try another');
            return Redirect::back()->withErrors(['email' => 'Email taken, please try another']);
        }
        // dd($request->checkout_preference);
        DB::beginTransaction();
        
        $warehouse = Warehouse::find($request->warehouse);
        $customer=new Customer;
        if($request->profile_image){
            $customer->profile_image = \Helper::upload_S3_image($request->profile_image,'public/images/','storage/images/profile_images/'); 
        }
        // $response = $customer->getAdressViaAPI($request->postcode);
        // if($response){
        //     $address = $response;
        // }else{
        //     $address = "";
        // }
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        if(isset($request->address_2)){
            $customer->address_2 = $request->address_2;  
        }
        $customer->warehouse = $request->warehouse;
        $customer->phone_number = $request->phone_number;
        $customer->city = $request->city;
        $customer->business_type = $request->business_type;
        $customer->business_name = $request->business_name;

        $customer->postal_code = $request->postcode;
        $customer->checkout_preference = ($request->checkout_preference)?$request->checkout_preference:'delivery';
		$customer->password = Hash::make($request->password);
        $password = $customer->password;
		
		$customer->save();
        $user = $customer;
        //code by Hassan
        $branch = new Branch();
        $branch->user_id = 5;//env('COMPANY_ID');
        $branch->name = $request->name;
        $branch->email = $request->email;
        $branch->city = $request->city;
        $branch->password = $password;
        $branch->business_type = $request->business_type;
        $branch->business_name = $request->business_name;
        $branch->warehouse = $request->warehouse;
        $branch->checkout_preference = ($request->checkout_preference)?$request->checkout_preference:'delivery';
        $branch->address = $request->address;
        $branch->phone = $request->phone_number;
        $branch->postal_code = $user->postcode;
        $branch->platform = 'Website';
        $branch->save();

        switch ($warehouse->name) {
            case 'BFD':
                $salespersonCode = "BFD MANGR";
                $resposibilityCenter = "BRADFORD";
                $customerPriceGroup = "BFD CC";
                break;
            case 'BDC':
                $salespersonCode = "BDC MANGR";
                $resposibilityCenter = "JACKSON ST";
                $customerPriceGroup = "BELLA PIZZ";
                break;
            case 'BOL':
                $salespersonCode = "BOL MANGR";
                $resposibilityCenter = "BOLTON";
                $customerPriceGroup = "BOL CC";
                break;
            case 'DIS':
                $salespersonCode = "DIST MANGR";
                $resposibilityCenter = "JACKSON ST";
                $customerPriceGroup = "DISTRIBUT";
                break;
            case 'LDS':
                $salespersonCode = "LDS MANGR";
                $resposibilityCenter = "LEEDS";
                $customerPriceGroup = "LDS CC";
                break;
            case 'SHE':
                $salespersonCode = "SHEFF MANG";
                $resposibilityCenter = "JACKSON ST";
                $customerPriceGroup = "SHEFFIELD";
                break;
            case 'BIR':
                $salespersonCode = "BIR MANG";
                $resposibilityCenter = "BIRG";
                $customerPriceGroup = "BIR CC";
                break;
            default:
                $salespersonCode = "LEEDS MANG";
                $resposibilityCenter = "LEEDS";
                $customerPriceGroup = "LDS CC";
                break;
        }
        
        $customers = [
            'Name'=>$request->name,
            'Name_2' => $request->name,
            'Search_Name'=>$request->name,
            'Address'=> $request->address,
            'Address_2' => ($request->address_2)?$request->address_2:'',
            'Country_Region_Code' => 'GB',
            'E_Mail'=>$request->email,
            'Phone_No'=>$request->phone_number,
            'MobilePhoneNo' => $request->phone_number,
            'City' => $request->city,
            "ContactName" => $request->name,
            "Gen_Bus_Posting_Group" => "DOMESTIC",
            "VAT_Bus_Posting_Group" => "DOMESTIC",
            "Customer_Posting_Group" => "DOMESTIC",
            // 'country' => 'UK',
            'Post_Code' => $request->postcode,
            "Location_Code" =>  $warehouse->name,

            'Salesperson_Code' => $salespersonCode,
            "Responsibility_Center" => $resposibilityCenter,
            "Customer_Price_Group" =>  $customerPriceGroup

        ];
        // dd($customer->id.' This is branch'.$branch->id);
        DB::commit();
        \Log::info('this is customer object', [$customers]);
        dispatch(new DynamicsCreateUser($customers,$customer->id,$branch->id));
        dispatch(new VerificationEmail($user));
    

        return redirect()->route('verification.notice')->with('success','Customer Registered Successfully.')->with(['id' => $user->id]);

        // return back()->with('success','Customer Registered Successfully.');
    }

    public function verifyCustomer(Request $request){
        $user = Customer::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));
        
            Customer::where('id', $request->route('id'))->update(['email_verified_at' => now()]);

        return redirect()->route('customer.login')->with('verified', true);
    }

    public function resetForm(){
        if(\Auth::guard('customer')->user()){
            return view('home');
        }
        return view('frontend.resetPassword');
    }

    public function resetLink(Request $request){
        $request->validate(['email' => 'required|email']);
 
        $status = \Illuminate\Support\Facades\Password::broker('customers')->sendResetLink(
            $request->only('email')
        );
    
        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassUser(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
     
        $status = \Illuminate\Support\Facades\Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Customer $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('customer.login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}