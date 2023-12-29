<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Setting;


use App\Customer;
use App\Jobs\DynamicsCCOrders;
use App\Jobs\DynamicsCreateDeliveryOrder;
use App\Jobs\DynamicsCreateUser;
use App\Jobs\DynamicsPaymentJob;
use App\Jobs\MailInvoiceJob;
use App\Sale;
use App\Warehouse;

class MSDynamicController extends Controller
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

    public function index()
    {
        $companies = $this->getCompanyList();
        $setting = Setting::pluck("setting_value", "setting_key");

        return view('admin.partials.ms.index', compact(
            'setting','companies'
        ));
    }


    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id.',id'],
            'role' => ['required']
        ];
        if(!$request->id){
            $role['password'] = ['required', 'string', 'min:8', 'confirmed'];
        } else {
            if($request->password){
                 $role['password'] = ['required', 'string', 'min:8', 'confirmed'];
            }
        }
        $request->validate($role);

        if($request->id){
            $admin = Admin::find($request->id);
        } else {
            $admin = new Admin;
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->password){
            $admin->password = Hash::make($request->password);
        }
        
        $admin->save();
        $admin->assignRole($request->role);

        
 
        return redirect()->route('admin.sub');
    }

    private function getCompanyList(){
        $payload = getAccessToken();
        Cache::forget('companies');
        $response = Cache::remember('companies', 86400, function () use($payload) {
            $result =  Http::withToken($payload['access_token']??"")->get('https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/production/api/v2.0/companies')->body();
            $result = json_decode($result);
            return $result->value??"";
        });
        
        return $response;
    }

    public function pushDynamics($sale_id){
        $sale = Sale::where('id',$sale_id)->first();
        $user = Customer::where('id',$sale->customer_id)->first();
        \Log::info('This is the HELPERS SALE FROM DB manual push', [$sale]);
        $DynamicData = \Helper::makeDynamicsJobData($sale,$user);
        \Log::info('This manual push', [$DynamicData]);
        if($sale->pick_time == null){
            dispatch(new DynamicsCreateDeliveryOrder($DynamicData['collectData'],$sale->id));
            dispatch(new DynamicsPaymentJob($DynamicData['payment']));
        }else{
            dispatch(new DynamicsCCOrders($DynamicData['collectData'],$sale->id));
            dispatch(new DynamicsPaymentJob($DynamicData['payment']));
        }
        $dataMsg = ['msg' => 'Your order has been recieved.%0D Thank you for placing your order with us. We\'re excited to fulfil your request. Below you\'ll find the details of your order, along with the attached invoice for your reference.', 'name' => $user->name];
        dispatch(new MailInvoiceJob($dataMsg, $sale->id, $user->email));

        $sale = Sale::where('id',$sale_id)->first();

        // if($sale->ms_order_no != null){
        //     // $sale->payment_status = "success";
        //     // $sale->ms_order_id = $data->orderId;
        //     // $sale->save();
        //     echo true;
        //     // return response()->json($data->merchantTransactionId, 200);
        // }
        // echo false;
        return response()->json(true);
    }
    public function PosPushDynamics($sale_id){
        $sale = Sale::where('id',$sale_id)->first();
        $user = Branch::where('id',$sale->branch_id)->with('getwarehouse')->first();
        \Log::info('This is the HELPERS SALE FROM DB manual push', [$sale]);
        $DynamicData = \Helper::PosMakeDynamicsJobData($sale,$user);
      //  dd($DynamicData);
        \Log::info('This manual push', [$DynamicData]);
        if($sale->pick_time == null){
            dispatch(new DynamicsCreateDeliveryOrder($DynamicData[0]['collectData'],$sale->id));
           // dispatch(new DynamicsPaymentJob($DynamicData['payment']));
        }
        $dataMsg = ['msg' => 'Your order has been recieved.%0D Thank you for placing your order with us. We\'re excited to fulfil your request. Below you\'ll find the details of your order, along with the attached invoice for your reference.', 'name' => $user->name];
        dispatch(new MailInvoiceJob($dataMsg, $sale->id, $user->email));

        $sale = Sale::where('id',$sale_id)->first();

        // if($sale->ms_order_no != null){
        //     // $sale->payment_status = "success";
        //     // $sale->ms_order_id = $data->orderId;
        //     // $sale->save();
        //     echo true;
        //     // return response()->json($data->merchantTransactionId, 200);
        // }
        // echo false;
        return response()->json(true);
    }
    public function pushDynamicsUser($user_id){
        $branch = Branch::where('id',$user_id)->first();
        $customer = Customer::where('email',$branch->email)->first();
        $warehouse = Warehouse::where('id',$customer->warehouse)->first();
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
            'Name'=>$customer->name,
            'Name_2' => $customer->name,
            'Search_Name'=>$customer->name,
            'Address'=> $customer->address,
            'Address_2' => ($customer->address_2)?$customer->address_2:'',
            'Country_Region_Code' => 'GB',
            'E_Mail'=>$customer->email,
            'Phone_No'=>$customer->phone_number,
            'MobilePhoneNo' => $customer->phone_number,
            'City' => $customer->city,
            "ContactName" => $customer->name,
            "Gen_Bus_Posting_Group" => "DOMESTIC",
            "VAT_Bus_Posting_Group" => "DOMESTIC",
            "Customer_Posting_Group" => "DOMESTIC",
            // 'country' => 'UK',
            'Post_Code' => $customer->postcode,
            "Location_Code" =>  $warehouse->name,

            'Salesperson_Code' => $salespersonCode,
            "Responsibility_Center" => $resposibilityCenter,
            "Customer_Price_Group" =>  $customerPriceGroup

        ];
        // dd($customer->id.' This is branch'.$branch->id);
        \Log::info('this is customer object', [$customers]);
        dispatch(new DynamicsCreateUser($customers,$customer->id,$branch->id));

        return response()->json(true);
    }



}
