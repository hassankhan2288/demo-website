<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Sale;
use App\Product_Sale;
use App\User;
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
        $this->middleware('auth:admin');
        generateBreadcrumb();

    }

    public function index()
    {
        $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
        $ending_date = date("Y-m-d");
        
        return view('admin.partials.report.index', compact('starting_date', 'ending_date'));
    }

    public function invoice($id)
    {  //dd(1);
        $sale = Sale::find($id);
        if(!$sale){
            return redirect()->route('admin.report');
        }
        $items = Product_Sale::where("sale_id",$id)->get();
        return view('admin.partials.report.invoice', compact('sale', 'items'));
    }


    public function ajax(Request $request){
        $user = Auth::user();
        //if ($request->ajax()) {
            $data = Sale::with("branch","user")->where(function($query) use($request) {
                if($request->payment_status){
                    $query->where("payment_status",$request->payment_status);
                }
                if($request->starting_date && $request->ending_date){
                    $query->whereDate("created_at", ">=", $request->starting_date)->whereDate("created_at", "<=", $request->ending_date);
                }
                if($request->user_id){
                    $query->where("user_id", $request->user_id);
                }
                if($request->branch_id){
                    $query->where("branch_id", $request->branch_id);
                }
            });
            return Datatables::of($data)
                ->with('total_tax', function() use ($data) {
                    return currency().$data->sum("order_tax");
                })
                ->with('total_amount', function() use ($data) {
                    return currency().$data->sum("paid_amount");
                })
                ->with('total_profit', function() use ($data) {
                    return currency().$data->sum("paid_amount") ;
                })
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    $date=date_create($row->created_at);
     
                    $btn = date_format($date,"d/m/Y");
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                }) 
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.report.invoice', $row->id).'" class="edit btn btn-primary btn-sm">Invoice</a>';
                    // $btn .= '<a href="'.route('app.branch.assign', $row->id).'" class="edit btn btn-info btn-sm ml-2">Assign product</a>';
                    return $btn;
                }) 
                ->rawColumns(['date','action'])
                ->make(true);
        //}
    }

    public function searchCompany(Request $request){
        $data = [];
        $data[] = ['text'=>"All", 'id'=>""];
        $users = User::where("name", "like", '%'.$request->search."%")->limit(10)->get();
        if($users){
            foreach ($users as $user) {
                $data[] = ['text'=>$user->name, 'id'=>$user->id];
            }
        }
        return  response()->json(['results'=>$data]);
    }

    public function searchBranch(Request $request){
        $data = [];
        $data[] = ['text'=>"All", 'id'=>""];
        $users = Branch::where("user_id",$request->user_id)->where("name", "like", '%'.$request->search."%")->limit(10)->get();
        if($users){
            foreach ($users as $user) {
                $data[] = ['text'=>$user->name, 'id'=>$user->id];
            }
        }
        return  response()->json(['results'=>$data]);
    }



}
