<?php

namespace App\Http\Controllers\Front;

use App\Branch;
use App\Brand;
use App\Category;
use App\Contacts;
use App\Customer;
// use App\PostTag;
// use App\PostCategory;
// use App\Post;
// use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductPricingManagement;
use App\Searchterm;
use App\Product_Sale;
use App\Sale;
use App\Subscribe;
use App\User;
use App\Stock;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use PDF;

class FrontendController extends Controller
{

    // public function index(Request $request){
    //     return redirect()->route($request->user()->role);
    // }

    // public function home(){
    //     $featured=Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
    //     $posts=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
    //     $banners=Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();
    //     // return $banner;
    //     $products=Product::where('status','active')->orderBy('id','DESC')->limit(8)->get();
    //     $category=Category::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
    //     // return $category;
    //     return view('frontend.index')
    //             ->with('featured',$featured)
    //             ->with('posts',$posts)
    //             ->with('banners',$banners)
    //             ->with('product_lists',$products)
    //             ->with('category_lists',$category);
    // }

    // public function aboutUs(){
    //     return view('frontend.pages.about-us');
    // }

    // public function contact(){
    //     return view('frontend.pages.contact');
    // }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
//        dd($product_detail->freeProduct);
       // dd(\Auth::guard('customer')->user()->id);
       // dd($product_detail->category_id);
        if(\Auth::guard('customer')->user()){
           $warehouse_id = \Auth::guard('customer')->user()->warehouse;
           $sto = Stock::where('product_id',$product_detail->id)->where('warehouse_id',$warehouse_id)->get();

            // dd($product_detail->stock->isNotEmpty());
          // dd($sto);
            if(count($sto)){
                $stock = $sto[0]['stocks'];
                //dd($stock);
            }else{
                $stock = 0;
            }

        }else{

           $warehouse_id = 0;
           $stock = 0;
        }

        $product_p = Product::where('category_id',$product_detail->category_id)->limit(8)->get();
        //dd($product_p);
        return view('frontend.product_detail', compact(['product_detail', 'product_p','warehouse_id','stock']));
    }
    public function design($id)
    {
        // dd('ok');
        if (isset($id)) {
            session()->put('design', $id);
        }

        return redirect()->back();
    }
    public function productPromotionsGrids()
    {
        //dd($_GET['show']);
        //$design = session('design', $id);
        //         if(isset($id)){
        // session()->put('design', $id);
        //         }

        $products = Product::query();
        $products->whereDate('StartingDate', '<=', date('Y-m-d'));
        $products->whereDate('EndingDate', '>=', date('Y-m-d'));
      //  echo date('Y-m-d');
        //dd($products);
        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty(Session::get('sortBy'))) {
            // if ($_GET['sortBy'] == 'title') {

            $products = $products->where('status', 'active')->orderBy('name', 'ASC');
            // }

            // if ($_GET['sortBy'] == 'price') {
            //     $products = $products->orderBy('price', 'ASC');
            // }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty(Session::get('show'))) {
            //dd(Session::get('show'));
            //dd(Session::get('show'),'ok');
            $products = $products->where('status', 'active')->paginate(Session::get('show'));

        } else {

            $products = $products->where('status', 'active')->paginate(12);
            //dd($products);
        }
        return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productGrids(Request $request)
    {
        //dd($_GET['show']);
        //$design = session('design', $id);
        //         if(isset($id)){
        // session()->put('design', $id);
        //         }

        $products = Product::query();

        // if (!empty($_GET['category'])) {
        //     $slug = explode(',', $_GET['category']);
        //     // dd($slug);
        //     $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
        //     // dd($cat_ids);
        //     $products->whereIn('cat_id', $cat_ids);
        //     // return $products;
        // }
        // if (!empty($_GET['brand'])) {
        //     $slugs = explode(',', $_GET['brand']);
        //     $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
        //     return $brand_ids;
        //     $products->whereIn('brand_id', $brand_ids);
        // }
        // if (!empty(Session::get('sortBy'))) {
        //    // if ($_GET['sortBy'] == 'title') {

        //         $products = $products->where('status', 'active')->orderBy('name', 'ASC');
        //    // }

        //     // if ($_GET['sortBy'] == 'price') {
        //     //     $products = $products->orderBy('price', 'ASC');
        //     // }
        // }

        // if (!empty($_GET['price'])) {
        //     $price = explode('-', $_GET['price']);
        //     // return $price;
        //     // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
        //     // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

        //     $products->whereBetween('price', $price);
        // }

        if($request->filter == true){
            // $products = $products->where(function($query) use($request){
            //     $ids = Category::where(['parent_id'=> $request->product_cat ])->pluck("id")->toArray();
            //     if(!$ids){
            //         $ids = [$request->slug];
            //     }
            //     $query->whereIn('category_id', $ids);
            // });

            if(isset($request->sortBy)){
                if($request->sortBy == 'name'){
                    $products = $products->orderBy('name', 'ASC');
                }
                if($request->sortBy == 'priceAsc'){
                   $products = $products->orderBy('price', 'ASC');
                }
                if($request->sortBy == 'priceDesc'){
                    $products = $products->orderBy('price', 'DESC');
                }
            }

            if(isset($request->show)){
                $products = $products->paginate($request->show);
            }else{
                $products = $products->paginate(15);
            }


        }else{
            $products=$products->where('status','active')->paginate(15);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        // if (!empty(\Session::get('show'))) {
        //     //dd(Session::get('show'));
        //     //dd(Session::get('show'),'ok');
        //     $products = $products->where('status', 'active')->paginate(Session::get('show'));

        // } else {

        //     $products = $products->where('status', 'active')->paginate(9);
        //     //dd($products);
        // }
        //$products=$products->where('status','active')->paginate(9);
        // Sort by name , price, category

        return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productLists()
    {
        //dd($_GET['show']);
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty(Session::get('sortBy'))) {
           // if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('name', 'ASC');
                //dd($products);
           // }
            // if ($_GET['sortBy'] == 'price') {
            //     $products = $products->orderBy('price', 'ASC');
            // }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty(Session::get('show'))) {
            //dd(Session::get('show'));
            $products = $products->where('status', 'active')->paginate(Session::get('show'));
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category

        //dd($products);
        // return view('frontend.product-grids')->with('products',$products)->with('recent_products',$recent_products);
        return back()->with('products', $products)->with('recent_products', $recent_products);
    }

    public function products_grid($id)
    {

        //dd($id);
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category

        return view('frontend.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productFilter(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // return $data;
        session()->forget('sortBy');
        session()->forget('show');
        $products = Product::query();

        if (!empty($data['category'])) {
            $slug = explode(',', $data['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($data['brand'])) {
            $slugs = explode(',', $data['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            // return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($data['sortBy'])) {
            if ($data['sortBy'] == 'name') {
                session()->put('sortBy', $data['sortBy']);

                $products = $products->where('status', 'active')->orderBy('name', 'ASC');
            }
            if($data['sortBy'] == 'price?sort=asc'){
                // $products = $products->orderBy('p_price', 'ASC')->orderBy('price', 'ASC')->orderBy('delivery_pack', 'ASC')->orderBy('delivery_single', 'ASC');
                $products = $products->orderBy('p_price', 'ASC');
            }
            if($data['sortBy'] == 'price?sort=desc'){
                // $products = $products->orderBy('p_price', 'DESC')->orderBy('price', 'DESC')->orderBy('delivery_pack', 'DESC')->orderBy('delivery_single', 'DESC');
                $products = $products->orderBy('p_price', 'DESC');
            }
            // if ($data['sortBy'] == 'price') {
            //     $products = $products->orderBy('price', 'ASC');
            // }
        }

        if (!empty($data['price'])) {
            $price = explode('-', $data['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if(!empty($data["product-cat"])){
            $cat_ids = Category::where(['parent_id'=>$data["product-cat"]])->pluck("id")->toArray();
            // dd($cat_ids);
            $products->whereIn('category_id', $cat_ids);
            // $products = $products->where('category_id', $data["product-cat"]);
        }
        if (!empty($data['show'])) {

            session()->put('show', $data['show']);
            $products = $products->where('status', 'active')->paginate($data['show'])->withQueryString();
        } else {
            $products = $products->where('status', 'active')->paginate(9)->withQueryString();
        }
        $filter = true;
        // Sort by name , price, category
        // dd($products);
        //dd(Session::get('show'));
        // return view('frontend.product-grids')->with('products',$products)->with('recent_products',$recent_products);
        return redirect()->back()->with('products', $products)->with('filter', $filter)->with('filters',$data);
    }
   
    public function productSearch(Request $request)
    {
        //dd($request->all());
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $products =Product::where(function($query) use ($request)
        {
            $query->orwhere('name', 'like', '%' . $request->search . '%');
            $query->orwhere('code', 'like', '%' . $request->search . '%');
            $query->orwhere('ms_id', 'like', '%' . $request->search . '%');
        })->where('is_active', '=', '1')

       // Product::orwhere('name', 'like', '%' . $request->search . '%')
       //   ->orwhere('code', 'like', '%' . $request->search . '%')
       //   ->orwhere('ms_id', 'like', '%' . $request->search . '%')
         ->orderBy('id', 'DESC')
           ->paginate('16');
            $searched=$request->search;

            SearchTerm::insert([
                'terms' => $request->search
            ]);
                
        return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products)->with('searched',$searched);
    }

    public function autocomplete(Request $request)
    {
        $hasil = SearchTerm::select("terms")
                    ->where('terms', 'LIKE', '%'. $request->get('query'). '%')
                    ->groupBy('terms')
                    ->get();
                    $data = array();
                    foreach ($hasil as $hsl)
                        {
                            $data[] = $hsl->terms;
                        }
                    //$data='pepsi';
        return response()->json($data);
    }
    public function subscribe1(Request $request)
    {

        return 1;
    }

    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }

    }
    // public function productCat(Request $request)
    // {
    //     // dd($request->slug);
    //     //$products=Category::getProductByCat($request->slug);
    //     // return $request->slug;
    //     $products = Product::query();
    //     if($request->filter == true){
    //         $products = $products->where(function($query) use($request){
    //             $ids = Category::where(['parent_id'=> $request->product_cat ])->pluck("id")->toArray();
    //             if(!$ids){
    //                 $ids = [$request->slug];
    //             }
    //             $query->whereIn('category_id', $ids);
    //         });
    //         $products->where('is_active',1);
    //         if(isset($request->sortBy)){
    //             if($request->sortBy == 'name'){
    //                 $products = $products->orderBy('name', 'ASC');
    //             }
    //             if($request->sortBy == 'priceAsc'){
    //                $products = $products->orderBy('price', 'ASC');
    //             }
    //             if($request->sortBy == 'priceDesc'){
    //                 $products = $products->orderBy('price', 'DESC');
    //             }
    //         }

    //         if(isset($request->show)){
    //             $products = $products->paginate($request->show);
    //         }else{
    //             $products = $products->paginate(15);
    //         }


    //     }else{
    //         // if (!empty(Session::get('sortBy'))) {
    //         //    // if ($_GET['sortBy'] == 'title') {
    //         //         $products = $products->where(function($query) use($request){
    //         //             $ids = Category::where(['parent_id'=>$request->slug])->pluck("id")->toArray();
    //         //             if(!$ids){
    //         //                 $ids = [$request->slug];
    //         //             }
    //         //             $query->whereIn('category_id', $ids);
    //         //         })->orderBy('name', 'ASC');
                    
    //         // }
    //         // if (!empty(Session::get('show'))) {
    //         //     //dd(Session::get('show'));
    //         //     $products = $products->where(function($query) use($request){
    //         //             $ids = Category::where(['parent_id'=>$request->slug])->pluck("id")->toArray();
    //         //             if(!$ids){
    //         //                 $ids = [$request->slug];
    //         //             }
    //         //             $query->whereIn('category_id', $ids);
    //         //         })->paginate(Session::get('show'));
    //         // } else {
    //             // dd('jkjhkjh');
    //             $products = $products->where(function($query) use($request){
    //                     $ids = Category::where(['parent_id'=>$request->slug])->pluck("id")->toArray();
    
    //                     if(!$ids){
    //                         $ids = [$request->slug];
    //                     }
    //                     $query->whereIn('category_id', $ids);
    //                 })->where('is_active',1)->paginate(15);
    //         // }
    //     }
    //    // $products1 = Product::find(2);
    //     //dd($products->web_price);
    //     $recent_products = Product::with('web_price')->where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
    //     //dd($recent_products->web_price);
    //     if (request()->is('e-shop.loc/product-grids')) {
    //         return view('frontend.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
    //     } else {

    //         return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    //         // return view('frontend.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
    //     }

    // }
    public function productCat(Request $request, $id)
    {
        // $category = $request->input('category');
    
        $group_name = config("app.group_website");
        $group = User::where('name', $group_name)->first();
        if ($group) {
            $products_ids = ProductPricingManagement::where('user_id', $group->id)->pluck('product_id');
            if (empty($products_ids)) {
                $products_ids = null;
            }
        } else {
            $products_ids = null;
        }
    
        $products = Product::query();
        $products = $products->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        });
    
        if ($request->filter == true) {
            if (isset($request->sortBy)) {
                if ($request->sortBy == 'name') {
                    $products = $products->orderBy('name', 'ASC');
                }
                if ($request->sortBy == 'priceAsc') {
                    $products = $products->orderBy('price', 'ASC');
                }
                if ($request->sortBy == 'priceDesc') {
                    $products = $products->orderBy('price', 'DESC');
                }
            }
    
            if (isset($request->show)) {
                $products = $products->paginate($request->show);
            } else {
                $products = $products->paginate(15);
            }
        } else {
            $products = $products->where(function ($query) use ($request, $id) {
                $query->whereHas('categories', function ($query) use ($id) {
                    $query->where('category_id', $id);
                });
                $query->where('status', 'active');
            })->paginate(15);
        }
    
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
    
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products)->with('products_ids', $products_ids);
        } else {
            return view('frontend.product-grids')->with('products', $products)->with('recent_products', $recent_products)->with('products_ids', $products_ids);
        }
    }
    
    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        }

    }

    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {

        //dd($request->all());
        //return redirect()->route('home');

        $sub = Subscribe::where('email', $request->email)->get();

        if (count($sub) > 0) {

            return redirect()->to(url()->previous() . '#form')->with('error', 'Already Subscribed');
        } else {

            Subscribe::insert(['email' => $request->email, 'status' => 1]);
            return redirect()->to(url()->previous() . '#form')->with('success', 'Email Subscribed! Successfully');

        }

        // if(! Newsletter::isSubscribed($request->email)){
        //         Newsletter::subscribePending($request->email);
        //         if(Newsletter::lastActionSucceeded()){
        //             request()->session()->flash('success','Subscribed! Please check your email');
        //             return redirect()->route('home');
        //         }
        //         else{
        //             Newsletter::getLastError();
        //             return back()->with('error','Something went wrong! please try again');
        //         }
        //     }
        //     else{
        //         request()->session()->flash('error','Already Subscribed');
        //         return back();
        //     }
    }

    public function contact_form(Request $request)
    {

        //dd($request->all());
        Contacts::insert(['name' => $request->name, 'email' => $request->email, 'phone' => '', 'subject' => $request->subject, 'message' => $request->message]);
        return redirect()->to(url()->previous() . '#contact_form')->with('contact_success', 'Contact Form Submited! Successfully');
    }
    public function termsAndCondition(){
        return view('frontend.terms_and_condition');
    }

    public function preferenceChange($preference){
        Customer::where('id', \Auth::guard('customer')->user()->id)->update(['checkout_preference' => $preference]);
        Branch::where('id', \Auth::guard('customer')->user()->id)->update(['checkout_preference' => $preference]);
        return back();
    }
    public function mypayment(Request $request){  
        $order_id = session()->get('order_id');
        dd( $order_id );
    }
    public function paymentScreen(Request $request){
       // dd(session());
        // $data = $request->except(['_token']);
        // if(empty($data)){
        //     return redirect()->route('checkout');
        // }
        $order_id = session()->get('order_id');
        $order_type = session()->get('order_type');
        if(!$order_id){
            if(!isset($request->order_id)){
                request()->session()->flash('error','Error');
                return back();
            }
            $order_id = $request->order_id;
        }
        $sale = Sale::where('id', $order_id)->first();
        $reference_no = $sale->reference_no;
        if($order_type == 'delivery'){
            $pick_date = null;
            $pick_time= null;
            $delivery_date = $sale->delivery_date;
        }else{
            $pick_time = $sale->pick_time;
            $pick_date = $sale->pick_date;
            $delivery_date = null;

        }
       
        // dd($reference_no);
        $env_variable = config('msdynamic.app_live');
       //  \Log::info('app env', [$env_variable]);
        // $env_variable = 'live';
        if($env_variable == "live"){
            $accestoken= 'https://e.connect.paymentsense.cloud/v1/access-tokens';
            $oderdesc = 'Live payment';
        }else{
            $accestoken= 'https://e.test.connect.paymentsense.cloud/v1/access-tokens';
            $oderdesc = 'Test Payment';
            // $accestoken= 'https://e.connect.paymentsense.cloud/v1/access-tokens';
            // $oderdesc = 'Live payment';
        }
        \Log::info('app env', [$env_variable]);
        $acces_token_url = $accestoken;
        // dd($data);
        // if($data['payment_method'] =='self' || isset($data['pick_time'])){
        //     $order=new Sale();
        //     $checkAvailability = $order->checkSlotsAvailability(\Auth::guard('customer')->user()->warehouse, $request->pick_time, $request->pick_date);
        //     if(!$checkAvailability){
        //         request()->session()->flash('error','Slot is full');
        //         return back();
        //     }
        // }
        $jwt_token = config('paymentsense.jwt_token');
        
        // $reference_no = "ORD-".now();
        $total_cart_price_without_vat = \Helper::totalCartPriceOfOrder($order_id);
        $vatprice= number_format(\Helper::totalCartVatPriceOfOrder($order_id),2);
        $total_price_with_vat =  str_replace(',','',$total_cart_price_without_vat + $vatprice);
        // dd($total_price_with_vat);
        $minor_unit_amount = round($total_price_with_vat * 100);
        //dd($total_price_with_vat);
        
        if($env_variable == "live"){
            $body['merchantUrl'] = 'https://www.caterchoice.com';//'https://e.connect.paymentsense.cloud/v1/access-tokens';
        }else{
            $body['merchantUrl'] = 'demo-dot-connect-e-build-non-pci.appspot.com';
            // $body['merchantUrl'] = 'https://www.caterchoice.com';//'https://e.connect.paymentsense.cloud/v1/access-tokens';
        }
         
        $body['merchantTransactionId'] = $reference_no;
        $body['currencyCode'] = '826';
        $body['amount'] = $minor_unit_amount;
        $body['transactionType'] = 'SALE';
        $body['orderId'] = $reference_no;
        $body['orderDescription'] =  $oderdesc;
        //\Log::info('JWT TOKEN', [$jwt_token]);
        if($env_variable == "live"){
            $body['webHookUrl'] =  "https://cater-choice.com/front/payment/webhook"; //Live
         }else{
             $body['webHookUrl'] =  "https://sale.cater-choice.com/front/payment/webhook"; // Staging
            //var_dump($acces_token_url);
         }
        $stocks =  Http::withHeaders([
            'authorization' => $jwt_token,
            'content-type' => 'application/json'
        ])->post($acces_token_url,$body)->body();

        $stocks = json_decode($stocks);
       // var_dump($stocks);
       \Log::info('paymentsense error log', [$body,$stocks,'vatprice',$vatprice,'amountWithoutVat',$total_cart_price_without_vat,'totalamount',$minor_unit_amount]);
       if(!isset($stocks->id)){
                request()->session()->flash('error','Paymentsense Gateway Issue');
                return back();
       }
        $payment_sense_token = $stocks->id;
        return view('frontend.payment',compact('payment_sense_token','env_variable','minor_unit_amount','reference_no','total_price_with_vat','delivery_date','pick_time','pick_date','order_id'));
     
    }
    public function generateInvoicePDF($id){
        $sale = Sale::find($id);
        $items = Product_Sale::where("sale_id",$id)->get();

        $pdf = PDF::loadView('frontend.invoice_pdf', compact('sale', 'items'));
        return $pdf->download('invoice.pdf');
        // return $pdf->stream('resume.pdf');
        // return response()->json(['flag' => true, 'pdf' => $pdf->stream('resume.pdf')]);
    }
}
