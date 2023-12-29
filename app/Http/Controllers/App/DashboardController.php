<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Branch;
use App\ProductPricingManagement;
use App\CustomerCategory;
use App\Sale;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        $user = Auth::user();
        $total_branch = Branch::where("user_id",$user->id)->count();
        $total_customer_cate = CustomerCategory::where("c_id",$user->id)->count();
        $total_product = ProductPricingManagement::where("user_id",$user->id)->count();
        $total_order = Sale::where("user_id",$user->id)->count();
        $reports = json_encode($this->getYearSale());
        $sale_by_branch = json_encode($this->saleByBranch());
        $last_month_sale = number_format($this->lastMonthSale(),2);
        $last_week_sale = number_format($this->lastWeekSale(),2);
        $current_month_sale = number_format($this->currentMonthSale(),2);
        $noti = Sale::groupBy('user_id')
        ->selectRaw('count(*) as total, user_id')->with('user')->where('sale_status','>',1)->where('user_id',$user->id)
        ->get()->take(10);

        //dd();


        return view('app.partials.dashboard.index', compact('total_branch', 'total_product', 'total_order', 'reports', 'sale_by_branch', 'last_month_sale', 'last_week_sale', 'current_month_sale','total_customer_cate','noti'));
    }

    private function getYearSale($year = null){
        $user = Auth::user();
        $year = $year ?? date('Y');
        $month_array = [];
        $amount_array = [];
        $month_amount_array = DB::select("select DATE_FORMAT(created_at, '%b')  as month, sum(grand_total) as total_amount from sales where year(created_at) = ? AND user_id = ?  group by DATE_FORMAT(created_at, '%b') order by created_at", [$year, $user->id]);

        foreach ($month_amount_array as $month_amount) {
            $month_array[] = $month_amount->month;
            $amount_array[] = $month_amount->total_amount;
        }
        $min_amount = DB::select("select min(grand_total) as min_amount from sales where year(created_at) = ? AND user_id = ?", [$year, $user->id]);
        $max_amount = DB::select("select sum(grand_total) as max_amount from sales where year(created_at) = ? AND user_id = ?", [$year, $user->id]);

        $data['month'] = $month_array;
        $data['amount'] = $amount_array;
        $data['min_amount'] = $min_amount[0]->min_amount ?? 0;
        $data['max_amount'] = $max_amount[0]->max_amount ?? 0;

        return $data;
    }

     private function lastMonthSale(){
         $user = Auth::user();
        $month = date("m", strtotime("first day of previous month"));

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ? AND user_id = ?", [$month, $user->id]);

        return $last_month_sale[0]->total_amount ?? 0;
    }

    private function lastWeekSale(){
        $user = Auth::user();
        $user_id = $user->id;
        $last_week_sale =  DB::select("SELECT sum(grand_total) as total_amount FROM sales WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND user_id = $user_id");

        return $last_week_sale[0]->total_amount ?? 0;
    }

    private function currentMonthSale(){
        $user = Auth::user();
        $month = date("m");

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ? AND user_id = ?", [$month, $user->id]);

        return $last_month_sale[0]->total_amount ?? 0;
    }

    private function saleByBranch(){
         $user = Auth::user();
        $sale_by_branch = DB::table('sales')
            ->selectRaw('sum(sales.grand_total) as value, branches.name')
            ->join('branches', 'branches.id', '=', 'sales.branch_id')
            ->groupBy("branches.name")
            ->where("sales.user_id", $user->id)
            ->get();

        return $sale_by_branch;
    }
}
