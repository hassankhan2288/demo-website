<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\AssignBranchProductPrice;
use App\User;

class CompanyAddPrice extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();
        $this->company = config("msdynamic.company_id");
        $this->environment = config("msdynamic.environment");
    }
    //
    public function GetCompanyPricing(Request $request){

    $companyid= $request->id;
    $company=User::select('*')->where('id',$companyid)->first();
    // dd($company);
     $response = getAccessToken();
     $result =  Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('My%20Company')/SalesPrice?\$expand=SalesPriceLines&\$filter=Code eq '$company->account'")->body();
     $result_d = json_decode($result);
     $items_d = collect($result_d->value);
     $items = $items_d[0]->SalesPriceLines;
     //dd( $items );
     dispatch(new AssignBranchProductPrice($items,$companyid));
     return back()->with('success','Product assign in queue, will be added soon');
       // dd($items_webd);
    }
}
