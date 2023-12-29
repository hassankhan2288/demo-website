<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Spatie\Permission\Models\Role;
use DataTables;

class AdminController extends Controller
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
        
        $admins = Admin::count();

        return view('admin.partials.admin.index', compact(
            'admins',
        ));
    }

    public function form(Request $request){
        $admin = Admin::find($request->id);
        $roles = Role::pluck("name", "id");
        $role_ids = [];
        if($admin){
            if($admin->roles){
                $role_ids = $admin->roles->pluck("id")->toArray();
            }
        }
        
        return view('admin.partials.admin.form', compact(
            'admin','roles','role_ids'
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

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = Admin::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $dropdown = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class=" dropdown-item" href="' . route('admin.sub.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>
                            <a class=" dropdown-item" href="' . route('admin.sub.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->guest(route( 'admin.login' ));
    }

    public function deleteAdmin(Request $request,$id)
    {
        $admin = Admin::where('id',$id)->first();
        // dd($admin);
        $admin->delete();
        return redirect()->route( 'admin.sub' )->with('success', 'Deleted successfully.');
    }

}
