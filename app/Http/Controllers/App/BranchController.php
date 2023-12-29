<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Branch;
use Spatie\Permission\Models\Role;
use App\ProductPricingManagement;
use App\ProductBranchManagement;
use DataTables;

class BranchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        generateBreadcrumb();

    }

    public function index()
    {
        
        $admins = Branch::count();

        return view('app.partials.branch.index', compact(
            'admins',
        ));
    }

    public function form(Request $request){
        $admin = Branch::find($request->id);
        $roles = Role::pluck("name", "id");
        $role_ids = [];
        if($admin){
            if($admin->roles){
                $role_ids = $admin->roles->pluck("id")->toArray();
            }
        }
        
        return view('app.partials.branch.form', compact(
            'admin','roles','role_ids'
        ));
    }

    public function submit(Request $request){
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
        $admin->phone = $request->phone??"";
        $admin->address = $request->address??"";
        if($request->password){
            $admin->password = Hash::make($request->password);
        }
        
        $admin->user_id = $user->id;
        $admin->save();
 
        return redirect()->route('app.branch');
    }

    public function ajax(Request $request){
        $user = Auth::user();
        //if ($request->ajax()) {
            $data = Branch::where("user_id",$user->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('app.branch.form', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }


    public function assign(Request $request){
        $branch_id = $request->id;
        //dd($company_id);
        return view('app.partials.branch.assign', compact('branch_id'));
    }

    public function branchProductAjax(Request $request){
         $data = ProductBranchManagement::with("product")->where("user_id",$request->user_id);
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



}
