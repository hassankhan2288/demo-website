<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;
use App\Category;
use App\Product;
use App\Brand;
use App\Banner;
use DB;
use Illuminate\Support\Facades\Storage;
use Phpfastcache\Helper\Psr16Adapter;

/*use vendor\autoload;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;*/

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function index()
    {

        $slider=Banner::where('type','website')->orderBy('id','DESC')->get();
        $mobile_slider=Banner::where('type','mobile')->orderBy('id','DESC')->get();
      //  $category_all = Category::where('is_active', true)->with('producthome')->limit(5)->get();
      //  $product_all = Product::where('is_active', true)->limit(9)->get();
        $brand_all = Brand::where('is_active', true)->get();
        $category_all = Category::where('is_active', true)->with('producthome')->limit(8)->get();
        $product_all = Product::where('is_active', true)->limit(5)->get();

    
        //dd($category_all);
        return view('frontend.home',compact('slider','brand_all','mobile_slider','category_all','product_all'));
    }

    public function promotion(){

        return view('frontend.promotion');
    }
    public function aboutus(){

        return view('frontend.aboutus');
    }

    public function contact(){

        return view('frontend.contact');
    }

    public function careers(){

        return view('frontend.careers');
    }
    public function gallery(){

        return view('frontend.gallery');
    }
    public function click(){

        return view('frontend.click');
    }
    public function products()
    {
        $slider=Banner::orderBy('id','DESC')->get();

        return view('frontend.product-lists',compact('slider'));
    }

    public static function categories($cat)
    {
        //dd(09);
         $category=Category::get();

        //return $slider=Category::orderBy('id','DESC')->get();
    }




}
