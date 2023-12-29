<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use DataTables;

class UserController extends Controller
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

        return view('admin.partials.user.index', compact(
            'users',
        ));
    }

    public function form(Request $request){
        $user = User::find($request->id);
        
        return view('admin.partials.user.form', compact(
            'user'
        ));
    }

    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'name' => ['required', 'string', 'max:255'],
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
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        
 
        return redirect()->route('admin.user');
    }

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.user.form', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }


}
