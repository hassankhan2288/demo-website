<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\OAuthClient;
use App\Customer;
use App\Warehouse;
use App\Order;
use App\Product_Sale;
use App\Sale;
use Helper;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
        generateBreadcrumb();
    }

    public function index(){

        $user = Auth::user();
        //dd($user);

        return view('frontend.customer.index', compact('user'));
    }

    public function orders(){

        $user = Auth::user();
        $orders = Sale::where('customer_id',$user->id)->orderBy('created_at','DESC')->get();
        return view('frontend.customer.orders', compact('user','orders'));

    }

    public function Order_Status(Request $request, $id)
     {
        $Order_Status= Sale::find($id);
        //dd($Order_Status);
        return redirect()->back();
        //->with('Order_id', $Order_Status->id)
        //->with('Shipping_Status', $Order_Status->Shipping_Status)
        //->with('Delivery_Status', $Order_Status->Delivery_Status)
        //->with('payment_status', $Order_Status->payment_status)
        //->with('payment_method', $Order_Status->payment_method);

        //->with('Order_Cancelled_On', $Order_Status->Order_Cancelled_On)

        //->with('Order_Cancel_Status', $Order_Status->Order_Cancel_Status);
    }
     public function Order_Cancel(Request $request,$id)
     {
        $Orders=Order::find($id);
        //date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        $Order_Cancelled_On =  date('d-m-Y h:i:s');
        $Orders->Order_Cancel_Status=1;
        $Orders->Order_Cancelled_On=$Order_Cancelled_On;
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();
         /* Email Alert Starts Here*/
         $email=$Orders->Customer_Emailid;
         $Order_Details=$Orders->Order_Details;
                $Delivery_Address=$Orders->Delivery_Address;
             $p_method=$Orders->paymentmode;
            $Amount=$Orders->Amount;
            $status=$Orders->p_status;
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;

        	                $welcomemessage='Hello '.$name.'';
        	                $emailbody='The Following Order is Cancelled Succesfully <br>
        	                <h4>Order Details: </h4><p> Order No:'.$id.$Order_Details.'</p>
        	                 <p><strong>Delivery Address:</strong>
        	               '.$Delivery_Address.'</p>
        	                <p> <strong>Total Amount:</strong>
        	                '.$Amount.'</p>
        	                 <p><strong>Payment Method:</strong>'.$p_method.'</p>
        	                  <p><strong>Payment Status:</strong>'.$status.'</p>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody

        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$id)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        ('Hey'.$name.' Your  Order No: '.$id.' Was Cancelled Succesfully');
        	                        $message->from('codetalentum@btao.in','CodeTalentum');

        	                    });
           /* Email Alert Ends Here*/
        return redirect()->back()->with('status','Order Cancelled Succesfully');

     }

     public function update(Request $request)
    {

                
                 $validation =$request->validate([
                       'name'=>'nullable|max:60',
                       'image'=>'',
                       'address'=>'',
                       'warehouse'=>'required',
                    //   'LandMark'=>'nullable|max:60',
                    //   'city'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
                    //   'state'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
                    //   'pincode'=>'nullable|digits_between:4,10',
                      'mno'=>'nullable',
                    //    'alternativemno'=>'nullable|digits:10',
                    //   'country'=>'nullable|max:30|regex:/^[a-zA-Z\s]*$/',
                // 'MobileNumber'=>'required|numeric',

                ]);
                  //print_r($validation);
                $name=$request->input('name');
                $address=$request->input('address');
                $warehouse=$request->input('warehouse');
                // $city=$request->input('city');
                // $state=$request->input('state');
                // $pincode=$request->input('pincode');
                $mno=$request->input('mno');
                // $alternativemno=$request->input('alternativemno');

                // $country=$request->input('country');
                if($request->input('warehouse') != \Auth::guard('customer')->user()->warehouse){
                    $cart = Helper::getAllProductFromCart();
                    if($cart->isNotEmpty()){
                        request()->session()->flash('error','Empty Cart First');
                        return back();
                    }
                }
                $user_id=Auth::user()->id;
                $user = Customer::where('id',$user_id)->update($request->except('_token'));
                if(isset($request->address_3)){
                    Customer::where('id',$user_id)->update(['address_3' => $request->address_3]);
                }
                if(isset($request->checkout_preference)){
                    Customer::where('id',$user_id)->update(['checkout_preference' => $request->checkout_preference]);
                }
                if(isset($request->profile_image)){
                    if(\Auth::guard('customer')->user()->profile_image != 'storage/default-avatar-profile.jpg'){
                        if(Storage::disk('s3')->exists(\Auth::guard('customer')->user()->profile_image)) {
                            Storage::disk('s3')->delete(\Auth::guard('customer')->user()->profile_image);
                        }
                    }
                    $image = \Helper::upload_S3_image($request->profile_image,'public/images/','storage/images/profile_images/');
                    Customer::where('id',$user_id)->update(['profile_image' => $image]);
                }
                // $user=Customer::findOrFail($user_id);
                //dd($user);
                // $user->name=$name;

                // $user->address=$address;
                // $user->address2=$request->address_1;
                // $user->city=$city;
                // $user->state=$state;
                // $user->pincode=$pincode;
                // $user->phone_number=$mno;
                // $user->warehouse=$warehouse;
                // $user->alternativemno=$alternativemno;

                // $user->country=$country;


                // if($request->hasfile('image'))
                // {
                //     $destination='Uploads/profiles/'.$user->image;
                //     if(File::exists($destination))
                //     {
                //         File::delete($destination);
                //     }
                //     $file=$request->file('image');
                //     $extension=$file->getClientOriginalExtension();
                //     $filename=time() .'.'.$extension;
                //     $file->move('Uploads/profiles/',$filename);
                //     $user->image=$filename;


                // }

                //   $user->update();
                   return redirect()->back()->with('success', 'Your Profile Data is Updated Succesfully');



    }

    public function updatepassword(Request $request)
         {
             $validation =$request->validate([
                       'newpass'=>'required',
                        'confirm_new_Pass'=>'required',

                ]);
                  //print_r($validation);
                $newpass=$request->input('newpass');
                $confirm_new_Pass=$request->input('confirm_new_Pass');
                if($confirm_new_Pass==$newpass)
                {
                    $user_id=Auth::user()->id;
                    $user_id=Auth::user()->id;
                    $user=Customer::findOrFail($user_id);
                    $user->password=Hash::make($newpass);
                    $user->update();
                    return redirect()->back()->with('successstatus', 'Password is Updated Succesfully');
                }
                else
                {

                    return redirect()->back()->with('passwordwontmatch', 'Password Wont Match! Please Try Again!!');

                }

         }



    public function profile(){

        $user = Auth::user();
        $warehouses = Warehouse::where('is_active',1)->get();
        // dd($user);

        return view('frontend.customer.profile', compact('user','warehouses'));
    }
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

    public function registerCustomer(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|max:255|unique:customers',
            'address'=>'required',
            'warehouse'=>'required|not_in:0',
            'password'=>'required|min:6|max:30|confirmed',
            'password_confirmation' =>'required|same:password'
        ]);

        $customer=new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->warehouse = $request->warehouse;
		$customer->password = Hash::make($request->password);

		$customer->save();

       // return back()->with('success','Customer Registered Successfully.');
        return redirect('customer/login')->with('success','Customer Registered Successfully.');
    }

    public function ajaxOrdersCustomer(Request $request){
        try {


            // ->orderBy('created_at','DESC')
            // ->offset($request->offset)
            // ->limit($request->limit);
            // echo json_encode($orders);


            $draw 				= 		$request->get('draw'); // Internal use
            $start 				= 		$request->get("start"); // where to start next records for pagination
            $rowPerPage 		= 		$request->get("length"); // How many recods needed per page for pagination

            $orderArray 	   = 		$request->get('order');
            $columnNameArray 	= 		$request->get('columns'); // It will give us columns array

            $searchArray 		= 		$request->get('search');
            $columnIndex 		= 		$orderArray[0]['column'];  // This will let us know,
            // which column index should be sorted
            // 0 = id, 1 = name, 2 = email , 3 = created_at

            $columnName 		= 		$columnNameArray[$columnIndex]['data']; // Here we will get column name,
            // Base on the index we get

            $columnSortOrder 	= 		$orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
            $searchValue 		= 		$searchArray['value']; // This is search value
            $user_id=\Auth::guard('customer')->user()->id;
            $orders = Sale::where('customer_id',$user_id);
            $total =  $orders->count();
            $totalFilter = $total;
            $arrData = $orders->skip($start)->take($rowPerPage);
            if($columnName && $columnSortOrder ){
                $arrData = $orders->orderBy($columnName,$columnSortOrder);
            }
            $arrData = $orders->get();

            $response = array(
               "draw" => intval($draw),
               "recordsTotal" => $total,
               "recordsFiltered" => $totalFilter,
               "data" => $arrData,
            );

            echo json_encode($response);


        } catch (\Throwable $th) {
            return back()->with('error','Server Error '.$th);
        }
    }

    public function invoice($id)
    {
        $user = Auth::guard('customer')->user();
        $sale = Sale::find($id);
        // if(!$sale){
        //     return redirect()->route('app.report');
        // }
        // if($sale->user_id!=$user->id){
        //     return redirect()->route('app.report');
        // }
        $items = Product_Sale::where("sale_id",$id)->get();
        // dd($items[0]->tax);
        return view('frontend.layouts.invoice', compact('sale', 'items'));
    }



}
