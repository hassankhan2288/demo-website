<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductPricingManagement;
use App\ProductBranchManagement;
use App\Product;
use App\CustomerCategory;
use DataTables;

class ProductController extends Controller
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
        
        return view('app.partials.product.index');
    }

    public function ajax(Request $request){ 
        $user = Auth::user();
        $data = ProductPricingManagement::with("product")->where("user_id",$user->id);
        $customer_category = CustomerCategory::where('c_id',$user->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('price', function($row){
                    $btn = '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'.currency().'</span></div><input type="text" value="'.$row->p_price.'" data-id="'.$row->id.'" data-price="'.$row->company_price.'" class="form-control company-price"></div>';
                    return $btn;
                })
                ->addColumn('cate', function($row) use ($customer_category) { 
                   // if(isset($row->categ->name)){
                        //$btn = $row->categ->name;

                        $btn = '<select class="form-control categ_sel" data-id="'.$row->id.'"  >';
                        $btn .= '<option value"0">Select Category</option>';
                        foreach ($customer_category as $key => $value) {
                            //dd($value->id);
                            $ide = $value->id;
                            $nme = $value->name;
                            if($row->cate == $ide){
                            $btn .= '<option value="'.$ide.'" name"'.$ide.'" selected>';
                            }else{
                              $btn .= '<option value="'.$ide.'" name"'.$ide.'">';  
                            }
                            
                            $btn .= $nme;
                            $btn .= '</option>';
                        }
                        
                        
                        $btn .= '</select>';
                    // }else{
                    //    $btn = '<select class="select_cate" name="categ_select">';
                    //     foreach ($customer_category as $key => $value) {
                    //        // dd($value);
                    //         $btn .= '<option value="'.$value->id.'">"'.$value->name.'"</option>';
                    //     }
                    //     $btn .= '</select>'; 
                    // }
                    
                    return $btn;
                })
                ->rawColumns(['price','cate'])
                ->make(true);
    }

    public function assignProduct(Request $request){

        //dd($request->product_id,$request->id);
        $pricing = ProductBranchManagement::firstOrNew(array('product_id' => $request->product_id, 'user_id'=>$request->id));
        $pricing->company_price = $request->price;
        $pricing->save();
        
        return redirect()->route('app.branch.assign',$request->id);
    }

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

    public function updatePrice(Request $request){
        $price = ProductPricingManagement::find($request->id);
        $price->p_price = $request->price;
        $price->save();
        return $price;
    }

    public function updateCate(Request $request){
        $price = ProductPricingManagement::find($request->id);
        //$customer_category = CustomerCategory::where('name',$request->cate)->get();
        $price->cate = $request->cate;
        $price->save();
        return $price;
    }



}
