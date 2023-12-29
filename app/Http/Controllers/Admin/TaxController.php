<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Tax;
use Spatie\Permission\Models\Role;
use DataTables;

class TaxController extends Controller
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
        
        return view('admin.partials.tax.index');
    }

    public function form(Request $request){
        $tax = Tax::find($request->id);
        
        return view('admin.partials.tax.form', compact(
            'tax'
        ));
    }

    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric'],
        ];

        $request->validate($role);

        if($request->id){
            $tax = Tax::find($request->id);
        } else {
            $tax = new Tax;
        }
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->is_active = 1;
        
        $tax->save();
        
 
        return redirect()->route('admin.tax');
    }

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = Tax::all();
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
                            <a class=" dropdown-item" href="' . route('admin.tax.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit </a>
                            <a class=" dropdown-item" href="' . route('admin.tax.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete </a>
                            </div>
                            </div>';
                
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function taxDelete(Request $request, $id)
    {
        $tax = Tax::where('id', $id)->delete();

        return redirect()->route('admin.tax')->with('success', 'Successfully deleted.');
    }

}
