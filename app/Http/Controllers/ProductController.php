<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Category;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page??0;

        $user = Auth::user();

        $per_page = $request->per_page ?? 10;

        $baseURL = "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/";

        $category_ids = Category::where("parent_id", $request->category_id)->get()->pluck("id")->toArray();


        $query = Product::where(function($query) use($request, $category_ids, $user){
            if($request->category_id){
                if($category_ids){
                    $query->whereIn("category_id", $category_ids);
                } else {
                    $query->where("category_id", $request->category_id);
                }
                
            }
            if($request->wishlist){
                $query->wherehas("wishlists", function($query) use($user) {
                    $query->where("wishlists.user_id", $user->id);
                });
            }
            if($request->search){

                $query->where('name', 'LIKE', '%'.$request->search.'%');
            }
            

        });

        $products = $query->paginate($per_page);
        $products->getCollection()->transform(function ($product) use ($baseURL) {
            $images = explode(',', $product->image);
            $firstImage = !empty($images) ? $baseURL . trim($images[0]) : null;
            $product->image = $firstImage;
            return $product;
        });
        $data['data'] = $products->items();
        $data['total'] = $products->total();
        $data['is_more'] = $products->hasMorePages();
        $data['page'] = $page+1;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function productPromotions(Request $request)
    {
        $baseURL = "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/";

        $products = Product::query();
        $products->whereDate('StartingDate', '<=', now());
        $products->whereDate('EndingDate', '>=', now());

        if (!empty($request->get('category'))) {
            $slug = explode(',', $request->get('category'));
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            $products->whereIn('cat_id', $cat_ids);
        }

        if (!empty($request->get('brand'))) {
            $slugs = explode(',', $request->get('brand'));
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            $products->whereIn('brand_id', $brand_ids);
        }

        if (!empty(Session::get('sortBy'))) {
            $products = $products->where('status', 'active')->orderBy('name', 'ASC');
        }

        if (!empty($request->get('price'))) {
            $price = explode('-', $request->get('price'));
            $products->whereBetween('price', $price);
        }

        if (!empty(Session::get('show'))) {
            $products = $products->where('status', 'active')->paginate($request->get('show', 12));
        } else {
            $products = $products->where('status', 'active')->paginate($request->get('show', 12));
        }

//        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

//        return response()->json([
//            'products' => $products,
////            'recent_products' => $recent_products,
//        ]);
        

        $products->getCollection()->transform(function ($product) use ($baseURL) {
            $images = explode(',', $product->image);
            $firstImage = !empty($images) ? $baseURL . trim($images[0]) : null;
            $product->image = $firstImage;
            return $product;
        });


        if ($products->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'No products found',
                ],
            ]);
        }

//        return response()->json($data);
    }
}
