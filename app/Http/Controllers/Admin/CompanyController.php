<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Branch;
use App\ProductPricingManagement;
use App\Product;
use App\CustomerCategory;
use App\Jobs\DynamicsCreateBranchUser;
use App\Services\MSDynamic;
use DataTables;
use Redirect;

class CompanyController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $users = User::count();

        return view('admin.partials.company.index', compact(
            'users',
        ));
    }

    public function form(Request $request){
        $user = User::find($request->id);
        

        return view('admin.partials.company.form', compact(
            'user',
        ));
    }

    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'name' => ['required', 'string', 'max:255'],
            'account' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id.',id']
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
            $user = User::find($request->id);
        } else {
            $user = new User;
        }
        $user->name = $request->name;
        $user->account = $request->account;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        
 
        return redirect()->route('admin.company');
    }
 
    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = User::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $btn = '<a href="'.route('admin.dashboard.company', $row->id).'" class="edit btn btn-primary btn-sm">'.$row->name.'</a>';
                    
                    return $btn;
                })
                ->addColumn('branch', function($row){
                    $branch = Branch::where('user_id',$row->id)->get();
                    $btn =count($branch);
                    
                    return $btn;
                })
                ->addColumn('products', function($row){
                    $products = ProductPricingManagement::where('user_id',$row->id)->get();
                    $btn =count($products);
                    
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.company.form', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= '<a href="'.route('admin.company.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Manual Assign product</a>';
                    $btn .= '<a href="'.route('admin.company.branch', $row->id).'" class="edit btn btn-info btn-sm ml-2">Add branch</a>';
                    $btn .= '<a href="'.route('companyprice.update', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign/Update Price</a>';
                    return $btn;
                })
                ->rawColumns(['name','branch','products','action'])
                ->make(true);
        //}
    }

    public function branchUpdate($id,$slug){
        
        $branch_id = $slug;
        $company_id = $id;

        $branch = Branch::where('id',$branch_id)->get();
        //dd($branch->getwarehouse->name);

        return view('admin.partials.company.branch_update', compact(
            'branch','branch_id','company_id'
        ));
    }
    public function branchDelete($id,$slug){
        $branch_id = $slug;
        $company_id = $id;
        $branch=Branch::findOrFail($branch_id);
        $status=$branch->delete();
        if($status){
            //request()->session()->flash('success','Banner successfully deleted');
            return Redirect::route('admin.company.branch', $company_id)->with('success', 'Branch deleted successfully.');
        }
        else{
           // request()->session()->flash('error','Error occurred while deleting banner');
            return Redirect::route('admin.company.branch', $company_id)->with('error', 'Error occurred while deleting Branch.');
        }
        //return redirect()->route('banner.index');
    }
    public function branchUpdated(Request $request){
        //dd($request->all());
        $branch_id = $request->branch_id;
        $company_id = $request->company_id;

        
            $branch = Branch::find($branch_id);
        
        $branch->name = $request->name;
        //$user->account = $request->account;
         $branch->warehouse = $request->warehouse_id;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
         $admin->ms_number = $request->ms_number;
        if($request->password){
            $branch->password = Hash::make($request->password);
        }
        
        $branch->save();

        
 
        //return redirect()->route('admin.company');
        return Redirect::route('admin.company.branch', $company_id)->with('success', 'Branch updated successfully.');
        

    }

    public function branchAjax(Request $request){
        $data = Branch::where("user_id",$request->user_id);
        $user_id=$request->user_id;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use($user_id){
                    $btn = '<a href="'.route('admin.company.branch.update', [$user_id,$row->id]).'" class="edit btn btn-primary btn-sm">Edit</a><a href="'.route('admin.company.branch.delete', [$user_id,$row->id]).'" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function branchAjaxBranches(Request $request){
        $data = Branch::all();
        
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function($row){
                    $data = User::all();
                    // if(isset($data[0]['name'])){
                    // $btn = $data[0]['name'];
                    // }else{
                    //    $btn =''; 
                    // }

                    $btn = '<select class="form-control categ_sel selected" data-id="'.$row->id.'"  >';
                        $btn .= '<option value"0">Select Category</option>';
                        foreach ($data as $key => $value) {
                            //dd($value->id);
                            $ide = $value->id;
                            $nme = $value->name;
                            if($row->user_id == $ide){
                            $btn .= '<option value="'.$ide.'" name"'.$ide.'" selected>';
                            }else{
                              $btn .= '<option value="'.$ide.'" name"'.$ide.'">';  
                            }
                            
                            $btn .= $nme;
                            $btn .= '</option>';
                        }
                        
                        
                        $btn .= '</select>';
                    
                    return $btn;
                })
                ->addColumn('action', function($row){
                    if($row->ms_number == null){
                        $dyn = '<button data-id="'.$row->id.'" class="pushDynamicsUser btn btn-default btn-sm mr-1" data-loading="<i class=\'fa fa-circle-o-notch fa-spin\'></i>">Push to Dynamic</button>';
                        return $dyn;
                    }
                })
                ->rawColumns(['company_name','action'])
                ->make(true);
    }

    public function updateCompany(Request $request){
        //dd($request->all());
        $price = Branch::find($request->id);
        //$customer_category = CustomerCategory::where('name',$request->cate)->get();
        $price->user_id = $request->cate;
        $price->save();
        return $price;
    }

    public function branchSubmit(Request $request, MSDynamic $api){
        $user = Auth::user();
        $input = $request->all();

        $role = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'numeric', 'digits:11'],
            'address' => ['nullable', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:branches,email,'.$request->id.',id'],
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
            $admin = Branch::find($request->id);
        } else {
            $admin = new Branch;
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->warehouse = $request->warehouse_id;
        $admin->ms_number = $request->ms_number;
        $admin->phone = $request->phone??"";
        $admin->address = $request->address??"";
        if($request->password){
            $admin->password = Hash::make($request->password);
        }
        
        $admin->user_id = $request->company_id;
        $admin->save();
        $customer = [
            'displayName'=>$request->name,
            'type'=>'Company',
            'addressLine1'=>$request->address,
            'email'=>$request->email,
            'phoneNumber'=>$request->phone,
        ];
       // dispatch(new DynamicsCreateBranchUser($customer, $admin));
        // $api->customer($customer, $admin);
 
        return redirect()->route('admin.company.branch', $request->company_id);
    }

    public function companyProductAjax(Request $request){
         $data = Product::whereDoesntHave("pricing", function($query) use($request){
            $query->where("user_id", $request->user_id);
         });
         //dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     $btn = '<a href="'.route('admin.company.form', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                //     $btn .= '<a href="'.route('admin.company.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                //     return $btn;
                // })
                //->rawColumns(['action'])
                ->make(true);
    }

    public function companyProductAssign(Request $request){

dd ($request->user_id);

        $data=explode(",",$request->ids[0]);

        $updateProduct = Product::whereIn('id',$ids)
                  ->update(['title' => 'My title']);

        dd($data);


    }

    public function companyProductAjaxAssigned(Request $request){
         $data = ProductPricingManagement::with("product","categ")->where("user_id",$request->user_id);
         //dd($request->user_id);
         $customer_category = CustomerCategory::where('c_id',$request->user_id)->get();
            return Datatables::of($data,$customer_category)
                ->addIndexColumn()
                ->addColumn('price', function($row){
                    $btn = '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'.currency().'</span></div><input type="text" value="'.$row->price.'" data-id="'.$row->id.'" data-price="'.$row->price.'" class="form-control company-price"></div>';
                    return $btn;
                })
                ->addColumn('p_price', function($row){
                    $btn = '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'.currency().'</span></div><input type="text" value="'.$row->p_price.'" data-id="'.$row->id.'" data-price="'.$row->p_price.'" class="form-control sale-price"></div>';
                    return $btn;
                })
                ->addColumn('cate', function($row) use ($customer_category) {
                   // if(isset($row->categ->name)){
                        //$btn = $row->categ->name;

                        $btn = '<select class="form-control categ_sel" data-id="'.$row->id.'"  >';
                        $btn .= '<option value"0">Select Category</option>';
                        foreach ($customer_category as $key => $value) {
                            //dd($value->id);
                            $ide = $value->id;
                            $nme = $value->name;
                            if($row->cate == $ide){
                            $btn .= '<option value"'.$ide.'" name"'.$ide.'" selected>';
                            }else{
                              $btn .= '<option value"'.$ide.'" name"'.$ide.'">';  
                            }
                            
                            $btn .= $nme;
                            $btn .= '</option>';
                        }
                        
                        
                        $btn .= '</select>';
                    // }else{
                    //    $btn = '<select class="select_cate" name="categ_select">';
                    //     foreach ($customer_category as $key => $value) {
                    //        // dd($value);
                    //         $btn .= '<option value="'.$value->id.'">"'.$value->name.'"</option>';
                    //     }
                    //     $btn .= '</select>'; 
                    // }
                    
                    return $btn;
                })
                ->rawColumns(['price','p_price','cate'])
                ->make(true);
    }

    public function assign(Request $request){
        $company_id = $request->id;
        $customer_category = CustomerCategory::where('c_id',$company_id)->get();
        //dd($customer_category->toArray());
        return view('admin.partials.company.assign', compact('company_id','customer_category'));
    }

    public function branch(Request $request){
        $company_id = $request->id;
        $user = User::find($request->id);
        return view('admin.partials.company.branch', compact('company_id', 'user'));
    }

    public function deleteAssignedProduct(Request $request)
    {      
//        dd($request->all());

        $product_assigned = $request->product_assigned_id;
//        dd($request->product_assigned_id);
        
        ProductPricingManagement::whereIn('id', $product_assigned)->delete();


        return redirect()->back();

    }
    public function CompanyPricingIndex()
    {
        
        return view('admin.partials.company_pricing.index');
    }

    public function CompanyPricingForm(Request $request){
        $product_price = ProductPricingManagement::find($request->id);
        $products = Product::all();
        $users = User::all();
      
        // dd($product_price);
        return view('admin.partials.company_pricing.form', compact(
            'product_price','products','users'
        ));
    }

    public function CompanyPricingSubmit(Request $request){
        $input = $request->all();

        $role = [
            'product_id' => ['required'],
            'product_ms_id' => ['required', 'string', 'max:255'],
            'product_ms_id' => ['required', 'string', 'max:255', 'unique:product_prices,product_ms_id,'.$request->id.',id'],
            'user_id' => ['required'],
            // 'price' => ['required'],
            // 'p_price' => ['required']
        ];

        $request->validate($role);

        if($request->id){
            $product_price = ProductPricingManagement::find($request->id);

        }
        $product_price->product_id = $request->product_id;
        $product_price->user_id = $request->user_id;
        $product_price->product_ms_id = $request->product_ms_id;
        $product_price->price = $request->price;
        $product_price->p_price = $request->p_price;
        // dd($product_price);
        $product_price->save();
        
 
        return redirect()->route('admin.company_pricing');
    }

    public function CompanyPricingAjax(Request $request){

        //if ($request->ajax()) {
            $data = ProductPricingManagement::with('product' , 'user')->orderBy('id', 'DESC')->get();
            // dd($data->toArray());
            // $data = Product_price::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('product_name', function($row) {
                    return $row->product ? $row->product->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $dropdown = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class=" dropdown-item" href="' . route('admin.company_pricing.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>
                            <a class=" dropdown-item" href="' . route('admin.company_pricing.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function CompanyPricingDelete(Request $request, $id)
    {
        $company_pricing = ProductPricingManagement::where('id', $id)->delete();

        return redirect()->route('admin.company_pricing')->with('success', 'Successfully deleted.');
    }



}