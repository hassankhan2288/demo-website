<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sale;
use App\ProductPricingManagement;
use App\CustomerCategory;
use Carbon\Carbon;
use DB; 

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $total_customer_cate = CustomerCategory::where("c_id",$user->user_id)->count();
        $total_product = ProductPricingManagement::where("user_id",$user->user_id)->count();
        $total_booking = 0;
        $total_new_booking = 0;
        $total_outstanding_booking = 0;
        $total_confirm_booking = 0;
        $total_pass_booking = 0;
        $total_fail_booking = 0; 
        $total_order = Sale::where("branch_id",$user->id)->count();
        $reports = json_encode($this->getYearSale());
        $last_month_sale = number_format($this->lastMonthSale(),2);
        $last_week_sale = number_format($this->lastWeekSale(),2);
        $current_month_sale = number_format($this->currentMonthSale(),2);
        $noti = Sale::groupBy('user_id')
        ->selectRaw('count(*) as total, user_id')->with('user')->where('sale_status','>',1)->where('branch_id',$user->id)
        ->get()->take(10);
        $currentDate = Carbon::now();
        $promotions = Promotion::whereDate('end_date', '>=', $currentDate)->where('status', 'active')->orderBy('id', 'DESC')->get();

        return view('pos.partials.dashboard.index', compact('total_order', 'reports', 'last_month_sale', 'last_week_sale', 'current_month_sale','total_customer_cate','total_product','noti','promotions'));
    }

     private function getYearSale($year = null){
        $user = Auth::user();
        $year = $year ?? date('Y');
        $month_array = [];
        $amount_array = [];
        $month_amount_array = DB::select("select DATE_FORMAT(created_at, '%b')  as month, sum(grand_total) as total_amount from sales where year(created_at) = ? AND branch_id = ?  group by DATE_FORMAT(created_at, '%b') order by created_at", [$year, $user->id]);

        foreach ($month_amount_array as $month_amount) {
            $month_array[] = $month_amount->month;
            $amount_array[] = $month_amount->total_amount;
        }
        $min_amount = DB::select("select min(grand_total) as min_amount from sales where year(created_at) = ? AND branch_id = ?", [$year, $user->id]);
        $max_amount = DB::select("select sum(grand_total) as max_amount from sales where year(created_at) = ? AND branch_id = ?", [$year, $user->id]);

        $data['month'] = $month_array;
        $data['amount'] = $amount_array;
        $data['min_amount'] = $min_amount[0]->min_amount ?? 0;
        $data['max_amount'] = $max_amount[0]->max_amount ?? 0;

        return $data;
    }

     private function lastMonthSale(){
         $user = Auth::user();
        $month = date("m", strtotime("first day of previous month"));

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ? AND branch_id = ?", [$month, $user->id]);

        return $last_month_sale[0]->total_amount ?? 0;
    }

    private function lastWeekSale(){
        $user = Auth::user();
        $user_id = $user->id;
        $last_week_sale =  DB::select("SELECT sum(grand_total) as total_amount FROM sales WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND branch_id = $user_id");

        return $last_week_sale[0]->total_amount ?? 0;
    }

    private function currentMonthSale(){
        $user = Auth::user();
        $month = date("m");

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ? AND branch_id = ?", [$month, $user->id]);

        return $last_month_sale[0]->total_amount ?? 0;
    }
}
