<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product_price;
use App\SearchTerm;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DataTables;

class ProductPriceController extends Controller
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
        
        return view('admin.partials.product_price.index');
    }

    public function form(Request $request){
        $product_price = Product_price::find($request->id);
        $warehouses = Warehouse::all();
        // dd($product_price);
        return view('admin.partials.product_price.form', compact(
            'product_price','warehouses'
        ));
    }

    public function submit(Request $request){
        $input = $request->all();

        $role = [
            'product_ms_id' => ['required', 'string', 'max:255'],
            'product_ms_id' => ['required', 'string', 'max:255', 'unique:product_prices,product_ms_id,'.$request->id.',id'],
            'warehouse_id' => ['required'],
            'price' => ['required'],
            'p_price' => ['required'],
            'delivery_single' => ['required'],
            'delivery_pack' => ['required'],
        ];

        $request->validate($role);

        if($request->id){
            $product_price = Product_price::find($request->id);

        }
        $product_price->product_ms_id = $request->product_ms_id;
        $product_price->warehouse_id = $request->warehouse_id;
        $product_price->price = $request->price;
        $product_price->p_price = $request->p_price;
        $product_price->delivery_single = $request->delivery_single;
        $product_price->delivery_pack = $request->delivery_pack;

        // dd($product_price);
        $product_price->save();
        
 
        return redirect()->route('admin.product_price');
    }

    public function ajax(Request $request){

        //if ($request->ajax()) {
            $data = Product_price::with('warehouse')->orderBy('id', 'DESC')->get();
            // dd($data->toArray());
            // $data = Product_price::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('warehouse_name', function($row) {
                    return $row->warehouse ? $row->warehouse->title : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $dropdown = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class=" dropdown-item" href="' . route('admin.product_price.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>
                            <a class=" dropdown-item" href="' . route('admin.product_price.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
        //}
    }

    public function productPriceDelete(Request $request, $id)
    {
        $coupon = Product_price::where('id', $id)->delete();

        return redirect()->route('admin.product_price')->with('success', 'Successfully deleted.');
    }

        // ** Search Term ** // 
    public function searchTermIndex()
    {
        
        return view('admin.partials.search_term.index');
    }

    public function searchTermForm(Request $request){
        $term = SearchTerm::find($request->id);
      
        return view('admin.partials.search_term.form', compact(
            'term'
        ));
    }

    public function searchTermSubmit(Request $request)
    {
        $input = $request->all();

        $role = [
            'terms' => ['required'],
        ];
        $request->validate($role);
        if($request->id){
            $term = SearchTerm::find($request->id);
        } else {
            $term = new SearchTerm;
        }
        $term->terms = $request->terms;
        $term->save();
 
        return redirect()->route('admin.search_term');
    }


    public function searchTermAjax(Request $request){
            $data = SearchTerm::select('id', 'terms', 'search', DB::raw('COUNT(*) as term_count'))
                ->groupBy('terms')->orderBy('id', 'DESC')->get();
                foreach ($data as $row) {
                    $row->search = $row->term_count;
                }
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
                            <a class=" dropdown-item" href="' . route('admin.search_term.form', $row->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>
                            <a class=" dropdown-item" href="' . route('admin.search_term.deleted', $row->id) . '" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                    return $dropdown;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function searchTermDelete(Request $request, $id)
    {
        $company_pricing = SearchTerm::where('id', $id)->delete();

        return redirect()->route('admin.search_term')->with('success', 'Successfully deleted.');
    }



}
