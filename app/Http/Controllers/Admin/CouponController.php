<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Coupon;
use Spatie\Permission\Models\Role;
use DataTables;

class CouponController extends Controller
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
        
        return view('admin.partials.coupon.index');
    }

    public function form(Request $request){
        $coupon = Coupon::find($request->id);
        
        return view('admin.partials.coupon.form', compact(
            'coupon'
        ));
    }

    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'code' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:coupons,code,'.$request->id.',id'],
            'amount' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'expired_date' => ['required'],
            'expired_date' => ['required'],
        ];

        $request->validate($role);

        if($request->id){
            $coupon = Coupon::find($request->id);

        } else {
            $coupon = new Coupon;
            $coupon->used = 0;
            $coupon->user_id = 0;
        }
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->amount = $request->amount;
        $coupon->quantity = $request->quantity;
        $coupon->expired_date = $request->expired_date;
        $coupon->is_active = 1;
        
        $coupon->save();
        
 
        return redirect()->route('admin.coupon');
    }

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = Coupon::all();
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
                            <a class=" dropdown-item" href="' . route('admin.coupon.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>
                            <a class=" dropdown-item" href="' . route('admin.coupon.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function couponDelete(Request $request, $id)
    {
        $coupon = Coupon::where('id', $id)->delete();

        return redirect()->route('admin.coupon')->with('success', 'Successfully deleted.');
    }



}
