<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Sale;
use App\Product_Sale;
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
        $this->middleware('auth:branch');
        generateBreadcrumb();

    }

    public function index()
    {
        $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
        $ending_date = date("Y-m-d");
        
        $currentDate = Carbon::now();
        $promotions = Promotion::whereDate('end_date', '>=', $currentDate)->where('status', 'active')->orderBy('id', 'DESC')->get();
        return view('pos.partials.report.index', compact('starting_date', 'ending_date','promotions'));
    }

    public function invoice($id)
    {
        $user = Auth::user();
        $sale = Sale::find($id);
        if(!$sale){
            return redirect()->route('pos.report');
        }
        if($sale->branch_id!=$user->id){
            return redirect()->route('pos.report');
        }
        $items = Product_Sale::where("sale_id",$id)->get();
        return view('pos.partials.report.invoice', compact('sale', 'items'));
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
            })->where("branch_id", $user->id);
            return Datatables::of($data)
                ->with('total_tax', function() use ($data) {
                    return currency().$data->sum("order_tax");
                })
                ->with('total_amount', function() use ($data) {
                    return currency().$data->sum("paid_amount");
                })
                ->with('total_profit', function() use ($data) {
                    return currency().$data->sum("paid_amount") - $data->sum("product_cost");
                    //return currency().$data->sum("paid_amount") - 0;
                    //return 0 - 0;
                })
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    $date=date_create($row->created_at);

                    $btn = date_format($date,"Y/m/d");
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                })

                ->addColumn('sale', function($row){
                    
if($row->sale_status == 1){
                    $btn = '<div class="badge badge-success">'.trans('file.Completed').'</div>';
                    //$sale_status = trans('file.Completed');
                }
                elseif($row->sale_status == 2){
                    $btn = '<div class="badge badge-danger">Rejected</div>';
                    //$sale_status = 'Rejected';
                }
                else{
                    $btn = '<div class="badge badge-warning">View</div>';
                    //$sale_status = 'View';
                }
                    //$btn = ;
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('pos.report.invoice', $row->id).'" class="edit btn btn-primary btn-sm">Invoice</a>';
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                })
                ->rawColumns(['date','sale','action'])
                ->make(true);
        //}
    }



}
