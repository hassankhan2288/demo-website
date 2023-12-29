<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\OAuthClient;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();
    }

    public function index(){

        $user = Auth::user();

        //dd($user->subscribedToPlan($monthly = 599820, 'default'));

        return view('admin.partials.account.index', compact('user'));
    }

    
    public function receipt(){

        $user = Auth::user();
        $receipts = $user->receipts()->get();

        $subscription = $user->subscription('default');


        return view('app.partials.account.receipt', compact('receipts', 'subscription'));
    }

    public function saveSettings(Request $request){
        $request->validate([
            "name"  => "required|string|max:25|min:3",
        ]);
        if($request->password){
           $request->validate([
                "password"  => "required|string|min:8|confirmed",
            ]); 
        }
        $user = Auth::user();
        $user->name = $request->name;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['success'=>true]);
    }

    public function logoutAdmin(Request $request)
{
   // dd($current_uri = request()->segments());

    Auth::logout();

    $request->session()->flush();

    $request->session()->regenerate();

    return redirect()->route( 'admin.login' );
}
    public function insertIntoCategoryProduct()
    {
        $products = Product::select('id', 'category_id')->get();

        foreach ($products as $product) {
            DB::table('category_product')->insert([
                'product_id' => $product->id,
                'category_id' => $product->category_id,
            ]);
        }

        return response()->json(['message' => 'Data inserted to CategoryProduct table successfully'], 200);
    }



}