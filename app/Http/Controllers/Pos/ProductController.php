<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductPricingManagement;
use App\ProductBranchManagement;
use App\Product;
use DataTables;
use Storage;

class ProductController extends Controller
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
        $currentDate = Carbon::now();
        $promotions = Promotion::whereDate('end_date', '>=', $currentDate)->where('status', 'active')->orderBy('id', 'DESC')->get();
        return view('pos.partials.product.index',compact('promotions'));
    }

    public function ajax(Request $request)
    {
            $user = Auth::user();
            $data = ProductPricingManagement::with("product",'categ')->where("user_id", $user->user_id);
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $product_image = null;

                    if($row->product != null) {
                        $product_image = explode(",", $row->product->image);
                        $product_image = htmlspecialchars($product_image[0]);
                        $product_image = str_replace('storage/','',$product_image);
                    }

                    $btn = $product_image ? '<img src="'.image_url('storage/thumbnail/'.$product_image).'" height="80" width="80">' : "";
                    return $btn;
                })
                ->addColumn('cate', function($row){
                    $btn = $row->categ != null ? $row->categ->name : "Not Selected";
                    return $btn;
                })
                ->rawColumns(['image','cate'])
                ->make(true);
    }


    public function addFavorite(Request $request){
        $product_price = ProductPricingManagement::find($request->id);
        $product_price->is_favorite = $request->is_favorite;
        $product_price->save();
        return response()->json("200");
    }

    // public function assignProduct(Request $request){

    //     //dd($request->product_id,$request->id);
    //     $pricing = ProductBranchManagement::firstOrNew(array('product_id' => $request->product_id, 'user_id'=>$request->id));
    //     $pricing->company_price = $request->price;
    //     $pricing->save();
        
    //     return redirect()->route('app.branch.assign',$request->id);
    // }

    public function adminProductSearch(Request $request){
        $user = Auth::user();
        //dd($user->id);
        $data = [];
        //$products = Product::where("name", "like", "%".$request->search."%")->limit(10)->get();
        $products = ProductPricingManagement::where('user_id',$user->id)->with("product")->get()->toArray();
//dd($products);
        if($products){
            foreach ($products as $key=>$product) {
                //dd($product['product']['name']);
                $data[] = ['text'=>$product['product']['name'], 'id'=>$product['product']['id'], 'product'=>$product['product']];
            }
        }
        return  ['results'=>$data];
    }



}
