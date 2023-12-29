<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Sale;
use App\Product_Sale;
use App\Branch;
use Spatie\Permission\Models\Role;
use App\ProductPricingManagement;
use App\ProductBranchManagement;
use DataTables;

class ReportController extends Controller
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
        $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
        $ending_date = date("Y-m-d");
        
        return view('app.partials.report.index', compact('starting_date', 'ending_date'));
    }

    public function invoice($id)
    {
        $user = Auth::user();
        $sale = Sale::find($id);
        if(!$sale){
            return redirect()->route('app.report');
        }
        if($sale->user_id!=$user->id){
            return redirect()->route('app.report');
        }
        $items = Product_Sale::where("sale_id",$id)->get();
        return view('app.partials.report.invoice', compact('sale', 'items'));
    }


    public function ajax(Request $request){
        $user = Auth::user();
        //if ($request->ajax()) {
            $data = Sale::with("branch")->where(function($query) use($request) {
                if($request->payment_status){
                    $query->where("payment_status",$request->payment_status);
                }
                if($request->starting_date && $request->ending_date){
                    $query->whereDate("created_at", ">=", $request->starting_date)->whereDate("created_at", "<=", $request->ending_date);
                }
                if($request->branch_id){
                    $query->where("branch_id", $request->branch_id);
                }
            })->where("user_id",$user->id);
            return Datatables::of($data)
                ->with('total_tax', function() use ($data) {
                    return currency().$data->sum("order_tax");
                })
                ->with('total_amount', function() use ($data) {
                    return currency().$data->sum("paid_amount");
                })
                ->with('total_profit', function() use ($data) {
                    return currency().$data->sum("paid_amount") - $data->sum("product_cost");
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('app.report.invoice', $row->id).'" class="edit btn btn-primary btn-sm">Invoice</a>';
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function searchBranch(Request $request){
        $user = Auth::user();
        $data = [];
        $data[] = ['text'=>"All", 'id'=>""];
        $users = Branch::where("user_id",$user->id)->where("name", "like", '%'.$request->search."%")->limit(10)->get();
        if($users){
            foreach ($users as $user) {
                $data[] = ['text'=>$user->name, 'id'=>$user->id];
            }
        }
        return  response()->json(['results'=>$data]);
    }



}
