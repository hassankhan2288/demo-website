<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Product_Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Admin;
use App\Product;
use App\Sale;
use App\ProductPricingManagement;
use App\CustomerCategory;
use App\Branch;
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
        
        $total_user = User::count();
        $total_admin = Branch::count();
        $total_product = Product::count();
        $total_order = Sale::count();
        $noti = Sale::groupBy('user_id')
        ->selectRaw('count(*) as total, user_id')->with('user')->where('sale_status','>',1)
        ->get()->take(10);
        //dd($noti->toArray());

        $total_new_booking = 0;
        $total_outstanding_booking = 0;
        $total_confirm_booking = 0;
        $total_pass_booking = 0;
        $total_fail_booking = 0;
        $reports = json_encode($this->getYearSale());
        $reports_monthly = json_encode($this->currentMonthSale());
        $sale_by_company = json_encode($this->saleByCompany());
        $last_month_sale = number_format($this->lastMonthSale(),2);
        $last_week_sale = number_format($this->lastWeekSale(),2);
        $current_month_sale = number_format($this->currentMonthSale(),2);
        $current_month_sale1 = json_encode($this->currentMonthSale1());


        $best_sellers = Product_Sale::leftJoin('products', function ($join) {
            $join->on('products.id', '=', 'product_sales.product_id');
        })->leftJoin('sales', function ($join) {
            $join->on('sales.id', '=', 'product_sales.sale_id');
        })->where('sales.status', 'POS')->groupBy('product_sales.product_id')->select(['products.*', DB::raw('SUM(products.price) as net_unit_price')
        ])->orderBy('net_unit_price', 'DESC')->take(5)->get();
        $new_customer = Branch::orderBy('created_at', 'Desc')->withCount('sale')->withSum('sale', 'grand_total')->withAvg('sale', 'grand_total')->limit(5)->get();
        $customers = Branch::withCount('sale')->withSum('sale', 'grand_total')->withAvg('sale', 'grand_total')
            ->whereHas('sale', function ($query) {
                $query->where('status', 'POS');
            })->limit(5)->get();
        $viewed_products = Product::take(5)->orderBy('count', 'DESC')->get();

            // B2C Queries
        $best_sellers_b2c = Product_Sale::leftJoin('products', function ($join) {
            $join->on('products.id', '=', 'product_sales.product_id');
        })->leftJoin('sales', function ($join) {
            $join->on('sales.id', '=', 'product_sales.sale_id');
        })->where('sales.status', 'website')->groupBy('product_sales.product_id')->select(['products.*', DB::raw('SUM(products.price) as net_unit_price')
        ])->orderBy('net_unit_price', 'DESC')->take(5)->get();
        $new_customer_b2c = Customer::orderBy('created_at', 'desc')->withCount('sale')->withSum('sale', 'grand_total')->withAvg('sale', 'grand_total')
        ->whereHas('sale', function ($query) {
        $query->where('status', 'website');
        })->limit(5)->get();
        $customers_b2c = Customer::withCount('sale')->withSum('sale', 'grand_total')->withAvg('sale', 'grand_total')
        ->whereHas('sale', function ($query) {
        $query->where('status', 'website');
             })->limit(5)->get();

        return view('admin.partials.dashboard.index', compact(
            'total_user',
            'total_admin',
            'total_product',
            'total_order',
            'total_new_booking',
            'total_outstanding_booking',
            'total_confirm_booking',
            'total_pass_booking',
            'total_fail_booking',
            'reports',
            'sale_by_company',
            'last_month_sale',
            'last_week_sale',
            'current_month_sale',
            'noti',
            'best_sellers',
            'new_customer',
            'customers',
            'viewed_products',
            'best_sellers_b2c',
            'new_customer_b2c',
            'customers_b2c',
            'current_month_sale1',
            'reports_monthly',
        ));
    }

    public function companyIndex($id)
    {
        //dd($id);
        $user = $id;
        $total_branch = Branch::where("user_id",$user)->count();
        $total_product = ProductPricingManagement::where("user_id",$user)->count();
        $total_categories = CustomerCategory::where("c_id",$user)->count();
        $total_order = Sale::where("user_id",$user)->count();
        $reports = json_encode($this->companyYearSale(null,  $user));
        $sale_by_branch = json_encode($this->saleByBranch($user));
        $last_month_sale = number_format($this->lastMonthSale(),2);
        $last_week_sale = number_format($this->lastWeekSale(),2);
        $current_month_sale = number_format($this->currentMonthSale(),2);
        $noti = Sale::groupBy('user_id')
        ->selectRaw('count(*) as total, user_id')->with('user')->where('sale_status','>',1)->where('user_id',$user)
        ->get()->take(10);
        $company_last_month_sale = number_format($this->companyLastMonthSale($user), 2);
        $company_last_week_sale = number_format($this->companyLastWeekSale($user), 2);
        $company_current_month_sale = number_format($this->companyCurrentMonthSale($user), 2);

        // dd($company_last_week_sale);

        return view('admin.partials.dashboard.company_index', compact('total_branch', 'total_product', 'total_order', 'reports', 'sale_by_branch', 'last_month_sale', 'last_week_sale', 'current_month_sale','total_categories',
            'noti','company_last_month_sale','company_last_week_sale','company_current_month_sale'));
    }

    private function saleByBranch($user){
         $user = $user;
        $sale_by_branch = DB::table('sales')
            ->selectRaw('sum(sales.grand_total) as value, branches.name')
            ->join('branches', 'branches.id', '=', 'sales.branch_id')
            ->groupBy("branches.name")
            ->where("sales.user_id", $user)
            ->get();

        return $sale_by_branch;
    }

    private function getYearSale($year = null){
        $year = $year ?? date('Y');
        $month_array = [];
        $amount_array = [];
        $month_amount_array = DB::select("select DATE_FORMAT(created_at, '%b')  as month, sum(grand_total) as total_amount from sales where year(created_at) = ? group by DATE_FORMAT(created_at, '%b')  order by created_at", [$year]);

        foreach ($month_amount_array as $month_amount) {
            $month_array[] = $month_amount->month;
            $amount_array[] = $month_amount->total_amount;
        }
        $min_amount = DB::select("select min(grand_total) as min_amount from sales where year(created_at) = ?", [$year]);
        $max_amount = DB::select("select sum(grand_total) as max_amount from sales where year(created_at) = ?", [$year]);

        $data['month'] = $month_array;
        $data['amount'] = $amount_array;
        $data['min_amount'] = $min_amount[0]->min_amount ?? 0;
        $data['max_amount'] = $max_amount[0]->max_amount ?? 0;

        return $data;
    }
    private function companyYearSale($year = null, $user_id = null){
        $year = $year ?? date('Y');
        $month_array = [];
        $amount_array = [];
        
        $query = DB::table('sales')->select(DB::raw("DATE_FORMAT(created_at, '%b') as month"), DB::raw("SUM(grand_total) as total_amount"))->whereYear('created_at', $year);
        if ($user_id !== null) {
            $query->where('user_id', $user_id);
        }
        $month_amount_array = $query->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))->orderBy('created_at')->get();
        
        foreach ($month_amount_array as $month_amount) {
            $month_array[] = $month_amount->month;
            $amount_array[] = $month_amount->total_amount;
        }
        $min_amount = DB::select("select min(grand_total) as min_amount from sales where year(created_at) = ? and user_id = ?", [$year , $user_id]);
        $max_amount = DB::select("select sum(grand_total) as max_amount from sales where year(created_at) = ? and user_id = ?", [$year , $user_id]);
        
        $data['month'] = $month_array;
        $data['amount'] = $amount_array;
        $data['min_amount'] = $min_amount[0]->min_amount ?? 0;
        $data['max_amount'] = $max_amount[0]->max_amount ?? 0;
    
        return $data;
    }
    

    private function lastMonthSale(){
        $month = date("m", strtotime("first day of previous month"));

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ?", [$month]);

        return $last_month_sale[0]->total_amount ?? 0;
    }
    private function companyLastMonthSale($user_id) {
        $month = date("m", strtotime("first day of previous month"));
    
        $company_last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ? and user_id = ?", [$month, $user_id]);
    
        return $company_last_month_sale[0]->total_amount ?? 0;
    }

    private function lastWeekSale(){

        $last_week_sale =  DB::select("SELECT sum(grand_total) as total_amount FROM sales WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY");

        return $last_week_sale[0]->total_amount ?? 0;
    }
    private function companyLastWeekSale($user_id) {
        $company_last_week_sale = DB::table('sales')
            ->select(DB::raw('sum(grand_total) as total_amount'))
            ->where('user_id', $user_id)
            ->where('created_at', '>=', DB::raw('curdate() - INTERVAL DAYOFWEEK(curdate()) + 6 DAY'))
            ->where('created_at', '<', DB::raw('curdate() - INTERVAL DAYOFWEEK(curdate()) - 1 DAY'))
            ->first();
    
        return $company_last_week_sale->total_amount ?? 0;
    }

    private function currentMonthSale1($day = null)
    {
        $day = $day ?? date('D');
        $day_array = [];
        $amount_array = [];
        // $month_amount_array = DB::select("SELECT MONTH(CURDATE()) AS CurrentMonth, sum(grand_total) as total_amount from sales 
        // where year(created_at) = ? group by DATE_FORMAT(created_at, '%b')  order by created_at", [$day]);

        $month_amount_array = DB::select(" SELECT DAY(created_at) AS Day, grand_total AS TotalSales
         FROM sales
         WHERE MONTH(created_at) = MONTH(CURDATE())
         AND YEAR(created_at) = YEAR(CURDATE())
         ORDER BY DAY(created_at)");
        // dd($month_amount_array);

        foreach ($month_amount_array as $month_amount) {
            $day_array[] = $month_amount->Day;
            $amount_array[] = $month_amount->TotalSales;
        }
        $min_amount = DB::select("select min(grand_total) as min_amount from sales where day(created_at) = ?", [$day]);
        $max_amount = DB::select("SELECT max( grand_total ) as max_amount from sales where day(created_at)");
        // dd($max_amount);
        

        // select max(grand_total) as max_amount from sales where month(created_at)

        $data['Day'] = $day_array;
        $data['TotalSales'] = $amount_array;
        // $data['min_amount'] = $min_amount[0]->min_amount ?? 0;
        $data['min_amount'] = 0;
        $data['max_amount'] = $max_amount[0]->max_amount ?? 0 ;
        // dd($data);
        return $data;

        // $month_amount_array = DB::select("select DAYNAME(created_at)  as days from sales
        // where MONTH(created_at) = MONTH(now())
        // and YEAR(created_at) = YEAR(now());");
        // dd($month_amount_array);

    }
    

    private function currentMonthSale(){
        $month = date("m");

        $last_month_sale = DB::select("select sum(grand_total) as total_amount from sales where month(created_at) = ?", [$month]);

        return $last_month_sale[0]->total_amount ?? 0;
    }

    private function companyCurrentMonthSale($user_id = null) {
        $month = date("m");
    
        $query = DB::table('sales')
            ->select(DB::raw('sum(grand_total) as total_amount'))
            ->whereMonth('created_at', $month);
    
        if ($user_id !== null) {
            $query->where('user_id', $user_id);
        }
    
        $company_current_month_sale = $query->first();
    
        return $company_current_month_sale->total_amount ?? 0;
    }
    
    private function saleByCompany(){
        $sale_by_branch = DB::table('sales')
            ->selectRaw('sum(sales.grand_total) as value, users.name')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->groupBy("users.name")
            ->get();

        return $sale_by_branch;
    }
}
