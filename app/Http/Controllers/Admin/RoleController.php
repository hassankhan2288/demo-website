<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;

class RoleController extends Controller
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
        
        $roles = Role::count();



        return view('admin.partials.role.index', compact(
            'roles',
        ));
    }

    public function form(Request $request){
        $role = Role::find($request->id);
        if($role){
            if($role->id===1){
                return redirect()->route('admin.role');
            }
        }
        $permissions = Permission::pluck("name","id");
        $permission_ids = [];
        if($role){
            if($role->permissions){
                $permission_ids = $role->permissions->pluck("id")->toArray();
            }
        }

        return view('admin.partials.role.form', compact(
            'role','permissions','permission_ids'
        ));
    }

    public function submit(Request $request){
        $input = $request->all();
 
        $request->validate([
            'name' => 'required|max:255|min:3',
            'permissions' => 'required|',
        ]);

        if($request->id){
            $role = Role::find($request->id);
        } else {
            $role = new Role;
        }
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        
 
        return redirect()->route('admin.role');
    }

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = Role::with("permissions")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = "";
                    if($row->id!==1){
                        $btn = '<a href="'.route('admin.role.form', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }


}
