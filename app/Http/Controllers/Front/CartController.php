<?php

namespace App\Http\Controllers\Front;

use App\Branch;
use App\Customer;
use App\Delivery_week;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Product;
use App\Wishlist;
use App\Cart;
use App\Leaves;
use App\Sale;
use App\Slots;
use App\Stock;
use App\Warehouse;
use Illuminate\Support\Str;
use Helper;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request, $slug){
        // dd($request->all());
        if (empty($slug)) {
            request()->session()->flash('error','Invalid Products');
            return back()->with('error','Invalid Products');
        }
        $product = Product::with('freeProduct')->where('slug', $slug)->first();
//        dd( $product);

        //(amount * 100) / 20
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back()->with('error','Invalid Products');
        }
        if(\Auth::guard('customer')->user() == false){

            return redirect()->route( 'customer.login' );
        }
        $user = Auth::guard('customer')->user();

        $stock = Stock::where('product_id',$product->id)->where('warehouse_id',$user->warehouse)->where('is_active',1)->where('stocks','>', 0)->first();
        if(!$stock){
            return back()->with('error','Out of stock, You can add other products.');
        }

        // dd($stock);
        $already_cart = Cart::where('user_id', \Auth::guard('customer')->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            if($already_cart->quantity > 10){
                return back()->with('error','Quantity limit reached');
            }
            if($already_cart->preference == "delivery"){
                if($already_cart->type == "CASE"){
                    $already_cart->amount = $product->Fullprice->delivery_pack + $already_cart->amount;
                }else{
                    $already_cart->amount = $product->Fullprice->delivery_single + $already_cart->amount;
                }
            }else{
                if($already_cart->type == "CASE"){
                    $already_cart->amount = $product->Fullprice->p_price + $already_cart->amount;
                }else{
                    $already_cart->amount = $product->Fullprice->price + $already_cart->amount;
                }
            }
            if(isset($product->tax->rate)){
                $vat_amount = ($already_cart->amount * $product->tax->rate) / 100;
                $already_cart->vat = $vat_amount;
            }else{
                $already_cart->vat = 0;
            }
            $already_cart->vat = $vat_amount;
            // $already_cart->amount = $already_cart->amount * $already_cart->quantity;
            // return $already_cart->quantity;
            if ($already_cart->product->qty < $already_cart->quantity || $already_cart->product->qty <= 0) return back()->with('error','Stock not sufficient!.');
            $already_cart->save();

//            if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
//                foreach ($product->freeProduct as $freeProduct) {
//                    if ($freeProduct->product_id === $product->id) {
//                        if ($freeProduct->quantity === $already_cart->quantity) {
//                            $freeCart = new Cart;
//                            $freeCart->user_id = \Auth::guard('customer')->user()->id;
//                            $freeCart->cart_id = $already_cart->id;
//                            $freeCart->product_id = $freeProduct->free_product_id;
//                            $freeCart->product_ms_id = $freeProduct->product->ms_id;
//                            $freeCart->quantity = 1;
//                            $freeCart->type = $request->pack_size;
//                            $freeCart->preference = $request->preference;
//                            $freeCart->amount = '0';
//                            $freeCart->vat = '0';
//                            $freeCart->save();
//                        }
//                    }
//                }
//            }
            if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                foreach ($product->freeProduct as $freeProduct) {
                    if ($freeProduct->product_id === $product->id) {
                        $cart_free_pro = Cart::where('user_id',$user->id)->where('product_id', $product->id)->where('preference',$request->preference)->whereNull('order_id')->whereNull('cart_id')->first();
                        $delete_cart_free_pro = Cart::where('user_id', $user->id)
                            ->where('product_id', $freeProduct->free_product_id)
                            ->where('preference', $request->preference)
                            ->where('cart_id', $cart_free_pro->id)
                            ->whereNull('order_id')
                            ->first();

                        if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                            $freeCart = new Cart;
                            $freeCart->user_id = \Auth::guard('customer')->user()->id;
                            $freeCart->cart_id = $already_cart->id;
                            $freeCart->product_id = $freeProduct->free_product_id;
                            $freeCart->product_ms_id = $freeProduct->product->ms_id;
                            $freeCart->quantity = 1;
                            $freeCart->type = $request->pack_size;
                            $freeCart->preference = $request->preference;
                            $freeCart->amount = '0';
                            $freeCart->vat = '0';
                            $freeCart->save();

                        }else{
                            if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                $delete_cart_free_pro->delete();
                            }
                        }
                    }
                }
            }

        }else{

            $cart = new Cart;
            $cart->user_id = \Auth::guard('customer')->user()->id;
            $cart->product_id = $product->id;
            $cart->product_ms_id = $product->ms_id;
            if(isset($request->quantity) && $request->quantity > 1){
                $cart->quantity = $request->quantity;
            }else{
                $cart->quantity = 1;
            }
            if($request->preference == "delivery"){
                if($request->pack_size == "CASE"){
                    //$cart->price = ($product->delivery_pack-($product->delivery_pack*$product->discount)/100);
                    $cart->price = $product->Fullprice->delivery_pack;
                    if(isset($product->tax->rate)){
                        $vat_amount = ($product->delivery_pack * $product->tax->rate) / 100;
                        $cart->vat = $vat_amount;
                    }else{
                        $cart->vat = 0;
                    }
                }else{
                    $cart->price = $product->Fullprice->delivery_single;
                    if(isset($product->tax->rate)){
                        $vat_amount = ($product->delivery_single * $product->tax->rate) / 100;

                        $cart->vat = $vat_amount;
                    }else{
                        $cart->vat = 0;
                    }
                }
            }else{
                if($request->pack_size == "CASE"){
                    $cart->price = $product->Fullprice->p_price;
                    if(isset($product->tax->rate)){
                        $vat_amount = ($product->Fullprice->p_price * $product->tax->rate) / 100;
                        $cart->vat = $vat_amount;
                    }else{
                        $cart->vat = 0;
                    }
                }else{
                    $cart->price = $product->Fullprice->price;
                    if(isset($product->tax->rate)){
                        $vat_amount = ($product->Fullprice->price * $product->tax->rate) / 100;
                        $cart->vat = $vat_amount;
                    }else{
                        $cart->vat = 0;
                    }
                }
            }
            // if(isset($product->tax->rate)){
            //     if($request->preference == "delivery"){
            //         if($request->pack_size == "CASE"){
            //             $vat_amount = ($cart->Fullprice->price * $product->tax->rate) / 100;
            //             $cart->vat = $vat_amount;
            //         }
            //     }else{ //collection vat calcualation
            //         $vat_amount = ($cart->Fullprice->price * $product->tax->rate) / 100;
            //         $cart->vat = $vat_amount;
            //     }
               
            // }else{
            //     $cart->vat = 0;
            // }
            $cart->vat = $vat_amount;
            $cart->type =  $request->pack_size;
            $cart->preference = $request->preference;
            $cart->amount= $cart->price * $cart->quantity;
            if ($cart->product->qty < $cart->quantity || $cart->product->qty <= 0) return back()->with('error','Stock not sufficient!.');
            $cart->save();
           // $wishlist=Wishlist::where('user_id',\Auth::guard('customer')->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);

            if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                $mainProductQuantityInCart = $cart->where('product_id', $product->id)->first();
                foreach ($product->freeProduct as $freeProduct) {
                    if ($freeProduct->product_id === $product->id) {
                        if ($freeProduct->quantity === $mainProductQuantityInCart->quantity) {
                            $freeCart = new Cart;
                            $freeCart->user_id = \Auth::guard('customer')->user()->id;
                            $freeCart->cart_id = $cart->id;
                            $freeCart->product_id = $freeProduct->free_product_id;
                            $freeCart->product_ms_id = $freeProduct->product->ms_id;
                            $freeCart->quantity = 1;
                            $freeCart->type = $request->pack_size;
                            $freeCart->preference = $request->preference;
                            $freeCart->amount = '0';
                            $freeCart->vat = '0';
                            $freeCart->save();
                        }
                    }
                }
            }

        }
        request()->session()->flash('success','Product successfully added to cart');
        return back()->with('success','Product successfully added to cart');
    }

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->all());
        if($request->quant[1] > 10){
            return back()->with('error','Max Quantity allowed is 10');
        }
        $user = Auth::guard('customer')->user();
//        $product = Product::where('slug', $request->slug)->first();
        $product = Product::with('freeProduct')->where('slug', $request->slug)->first();

        //dd($product);

        $stock = Stock::where('product_id',$request->product_id)->where('warehouse_id',$user->warehouse)->where('is_active',1)->first();
        if(!$stock || $stock->stocks < 1){
            return back()->with('error','Out of stock, You can add other products.');
        }

        if($request->has('home') && $request->home == "singular"){
            // dd('if');
            if(\Auth::guard('customer')->user() == false){

                return redirect()->route( 'customer.login' );
            }



            //dd($product,$request->slug,\Auth::guard('customer')->user()->id);
            // if($product->qty <$request->quant){
            //     //dd($product->qty,1);
            //     return back()->with('error','Out of stock, You can add other products.');
            // }
            if ( ($request->quant < 1) || empty($product) ) {
                //dd($request->quant[1],2);
                request()->session()->flash('error','Invalid Products');
                return back();
            }
                //dd($product->qty,1);
            $already_cart = Cart::where('user_id', \Auth::guard('customer')->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();

            // return $already_cart;
            //dd($already_cart,1);
            if($already_cart) {
                $already_cart->quantity = $already_cart->quantity + $request->quant;
                if($already_cart->quantity > 10){
                    return back()->with('error','Max Quantity allowed is 10');
                }
                // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
                //$totalamount= ($product->price * $already_cart->quantity)+ $already_cart->amount;
                $totalamount= $already_cart->price * $already_cart->quantity;
                $already_cart->amount = number_format($totalamount, 2);
               // \Log::info($already_cart->quantity,$totalamount);
                //tax calculation from db if id 1 tax will be apply 20% other wise 0


               // if ($already_cart->product->qty < $already_cart->quantity || $already_cart->product->qty <= 0) return back()->with('error','Stock not sufficient!.');
                if($stock->stocks < $already_cart->quantity){
                    return back()->with('error','Stock not sufficient!');
                }
                if(isset($product->tax->rate)){
                    $vat_amount = ($already_cart->amount * $product->tax->rate) / 100;
                }else{
                    $vat_amount = 0;
                }
                // if($product->tax_id==1){
                //     $taxamount = $already_cart->amount*20/100;
                // }else{
                //     $taxamount =0;
                // }
                $already_cart->vat = $vat_amount;
                $already_cart->save();

                if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                    foreach ($product->freeProduct as $freeProduct) {
                        if ($freeProduct->product_id === $product->id) {
                            $cart_free_pro = Cart::where('user_id',$user->id)->where('product_id', $product->id)->where('preference',$request->preference)->whereNull('order_id')->whereNull('cart_id')->first();
                            $delete_cart_free_pro = Cart::where('user_id', $user->id)
                                ->where('product_id', $freeProduct->free_product_id)
                                ->where('preference', $request->preference)
                                ->where('cart_id', $cart_free_pro->id)
                                ->whereNull('order_id')
                                ->first();

                            if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                                $freeCart = new Cart;
                                $freeCart->user_id = \Auth::guard('customer')->user()->id;
                                $freeCart->cart_id = $already_cart->id;
                                $freeCart->product_id = $freeProduct->free_product_id;
                                $freeCart->product_ms_id = $freeProduct->product->ms_id;
                                $freeCart->quantity = 1;
                                $freeCart->type = $request->type;
                                $freeCart->preference = $request->preference;
                                $freeCart->amount = '0';
                                $freeCart->vat = '0';
                                $freeCart->save();

                            }else{
                                if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                    $delete_cart_free_pro->delete();
                                }
                            }
                        }
                    }
                }
            }else{
               // dd(3);
                $cart = new Cart;
                $cart->user_id = \Auth::guard('customer')->user()->id;
                $cart->product_id = $product->id;
                $cart->product_ms_id = $product->ms_id;
                $cart->price = ($product->price-($product->price*$product->discount)/100);
                $cart->quantity = $request->quant;

                $cart->amount=($product->price * $request->quant);

                if(isset($product->tax->rate)){
                    $vat_amount = ($cart->amount * $product->tax->rate) / 100;
                }else{
                    $vat_amount = 0;
                }
                // if($product->tax_id==1){
                //     $taxamount = $cart->amount*20/100;
                // }else{
                //     $taxamount =0;
                // }
                $already_cart->vat = $vat_amount;

                $cart->type ="SINGLE";
              //  if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
                // return $cart;
                $cart->save();

                if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                    foreach ($product->freeProduct as $freeProduct) {
                        if ($freeProduct->product_id === $product->id) {
                            $cart_free_pro = Cart::where('user_id',$user->id)->where('product_id', $product->id)->where('preference',$request->preference)->whereNull('order_id')->whereNull('cart_id')->first();
                            $delete_cart_free_pro = Cart::where('user_id', $user->id)
                                ->where('product_id', $freeProduct->free_product_id)
                                ->where('preference', $request->preference)
                                ->where('cart_id', $cart_free_pro->id)
                                ->whereNull('order_id')
                                ->first();

                            if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                                $freeCart = new Cart;
                                $freeCart->user_id = \Auth::guard('customer')->user()->id;
                                $freeCart->cart_id = $cart->id;
                                $freeCart->product_id = $freeProduct->free_product_id;
                                $freeCart->product_ms_id = $freeProduct->product->ms_id;
                                $freeCart->quantity = 1;
                                $freeCart->type = $request->type;
                                $freeCart->preference = $request->preference;
                                $freeCart->amount = '0';
                                $freeCart->vat = '0';
                                $freeCart->save();

                            }else{
                                if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                    $delete_cart_free_pro->delete();
                                }
                            }
                        }
                    }
                }
            }
            //request()->session()->flash('success','Product successfully added to cart.');
            return back()->with('success','Product successfully added to cart.');
        }else{
            // dd($request->all());
            if(\Auth::guard('customer')->user() == false){

                return redirect()->route( 'customer.login' );
            }


           // $product = Product::where('slug', $request->slug)->with('Fullprice')->first();
            $product = Product::with('freeProduct')->where('slug', $request->slug)->first();
        //    dd($product);

            //dd($product,$request->slug,\Auth::guard('customer')->user()->id);
            if($request->quant[1] > 10){
                return back()->with('error','Max Quantity allowed is 10');
            }
           // $stock = Stock::where('product_id',$product->id)->where('warehouse_id',$user->warehouse)->where('is_active',1)->first();
            if(!$stock || $stock->stocks < 1){
                return back()->with('error','Out of stock, You can add other products.');
            }


            if ( ($request->quant[1] < 1) || empty($product) ) {
                //dd($request->quant[1],2);
                request()->session()->flash('error','Invalid Products');
                return back();
            }

            $already_cart = Cart::where('user_id', \Auth::guard('customer')->user()->id)->where('order_id',null)->where('product_id', $product->id)->where('type', $request->type)->first();


            if($already_cart) {
                $already_cart->quantity = $already_cart->quantity + $request->quant[1];

                if($already_cart->quantity > 10){
                    return back()->with('error','Max Quantity allowed is 10');
                }
                // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
                if($already_cart->preference == "delivery"){
                    if($already_cart->type == "CASE"){
                        $already_cart->amount = $product->Fullprice->delivery_pack * $already_cart->quantity;
                    }else{
                        $already_cart->amount = $product->Fullprice->delivery_single* $already_cart->quantity;
                    }
                }else{
                    if($already_cart->type == "CASE"){
                        $already_cart->amount = $product->Fullprice->p_price * $already_cart->quantity;
                    }else{
                        $already_cart->amount = $product->Fullprice->price * $already_cart->quantity;
                    }
                }
                //tax calculation from db if id 1 tax will be apply 20% other wise 0
                if(isset($product->tax->rate)){
                    $vat_amount = ($already_cart->amount * $product->tax->rate) / 100;
                }else{
                    $vat_amount = 0;
                }
                // if($product->tax_id==1){
                //     $taxamount = $already_cart->amount*20/100;
                // }else{
                //     $taxamount =0;
                // }
                $already_cart->vat = $vat_amount;
                //tax calculation end here
                // if($request->type == "pickup"){
                //     $already_cart->amount = ($product->p_price * $request->quant[1])+ $already_cart->amount;
                // }else{
                //     $already_cart->amount = ($product->delivery_price * $request->quant[1])+ $already_cart->amount;
                // }

                //if ($already_cart->product->qty < $already_cart->quantity || $already_cart->product->qty <= 0) return back()->with('error','Stock not sufficient!.');
                if($stock->stocks < $already_cart->quantity){
                    return back()->with('error','Limited Stock Available');
                }
                $already_cart->save();

                if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                    foreach ($product->freeProduct as $freeProduct) {
                        if ($freeProduct->product_id === $product->id) {
                            $cart_free_pro = Cart::where('user_id', $user->id)->where('product_id', $product->id)->where('preference', $request->preference)->whereNull('order_id')->whereNull('cart_id')->first();
                            $delete_cart_free_pro = Cart::where('user_id', $user->id)
                                ->where('product_id', $freeProduct->free_product_id)
                                ->where('preference', $request->preference)
                                ->where('cart_id', $cart_free_pro->id)
                                ->whereNull('order_id')
                                ->first();

                            if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                                $freeCart = new Cart;
                                $freeCart->user_id = \Auth::guard('customer')->user()->id;
                                $freeCart->cart_id = $already_cart->id;
                                $freeCart->product_id = $freeProduct->free_product_id;
                                $freeCart->product_ms_id = $freeProduct->product->ms_id;
                                $freeCart->quantity = 1;
                                $freeCart->type = $request->type;
                                $freeCart->preference = $request->preference;
                                $freeCart->amount = '0';
                                $freeCart->vat = '0';
                                $freeCart->save();

                            } else {
                                if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                    $delete_cart_free_pro->delete();
                                }
                            }
                        }
                    }
                }

            }else{

                if($request->quant[1] > 10){
                    return back()->with('error','Max Quantity allowed is 10');
                }
                $cart = new Cart;
                $cart->user_id = \Auth::guard('customer')->user()->id;
                $cart->product_id = $product->id;
                $cart->product_ms_id = $product->ms_id;
                if($request->preference == "delivery"){
                    if($request->type == "CASE"){
                        $cart->price = $product->Fullprice->delivery_pack;
                    }else{
                        $cart->price = $product->Fullprice->delivery_single;
                    }
                }else{
                    if($request->type == "CASE"){
                        $cart->price = $product->Fullprice->p_price;
                    }else{
                        $cart->price = $product->Fullprice->price;
                    }
                }

                if($request->preference == "delivery"){
                    if($request->type == "CASE"){
                        $cart->amount=($product->Fullprice->delivery_pack * $request->quant[1]);
                    }else{
                        $cart->amount=($product->Fullprice->delivery_single * $request->quant[1]);
                    }
                }else{
                    if($request->type == "CASE"){
                        $cart->amount=($product->Fullprice->p_price * $request->quant[1]);
                    }else{
                        $cart->amount=($product->Fullprice->price * $request->quant[1]);
                    }
                }
                //tax calculation from db if id 1 tax will be apply 20% other wise 0
                if(isset($product->tax->rate)){
                    $vat_amount = ($cart->amount * $product->tax->rate) / 100;
                }else{
                    $vat_amount = 0;
                }

                // if($product->tax_id==1){
                //     $taxamount = $cart->amount*20/100;
                // }else{
                //     $taxamount =0;
                // }
                $cart->vat = $vat_amount;
                //tax calculation end here


                $cart->quantity = $request->quant[1];
                $cart->type = $request->type;
                $cart->preference = $request->preference;
                $cart->save();

                if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                    foreach ($product->freeProduct as $freeProduct) {
                        if ($freeProduct->product_id === $product->id) {
                            $cart_free_pro = Cart::where('user_id', $user->id)->where('product_id', $product->id)->where('preference', $request->preference)->whereNull('order_id')->whereNull('cart_id')->first();
                            $delete_cart_free_pro = Cart::where('user_id', $user->id)
                                ->where('product_id', $freeProduct->free_product_id)
                                ->where('preference', $request->preference)
                                ->where('cart_id', $cart_free_pro->id)
                                ->whereNull('order_id')
                                ->first();

                            if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                                $freeCart = new Cart;
                                $freeCart->user_id = \Auth::guard('customer')->user()->id;
                                $freeCart->cart_id = $cart->id;
                                $freeCart->product_id = $freeProduct->free_product_id;
                                $freeCart->product_ms_id = $freeProduct->product->ms_id;
                                $freeCart->quantity = 1;
                                $freeCart->type = $request->type;
                                $freeCart->preference = $request->preference;
                                $freeCart->amount = '0';
                                $freeCart->vat = '0';
                                $freeCart->save();

                            } else {
                                if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                    $delete_cart_free_pro->delete();
                                }
                            }
                        }
                    }
                }
            }
            //request()->session()->flash('success','Product successfully added to cart.');
            return back()->with('success','Product successfully added to cart.');
        }


        //return back()->with(['success' => 'Product successfully added to cart.']);
    }

    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            if (!$cart->price == 0){
                $cart->delete();
                $cartFreeProducts = Cart::where('cart_id', $request->id)->delete();

                request()->session()->flash('success','Cart successfully removed');
                return back();
            }else{
                request()->session()->flash('error','Can Not Delete Free Product');
                return back();
            }

        }
        request()->session()->flash('error','Error please try again');
        return back();
    }

    public function cartUpdate(Request $request){
        //  dd($request->all());
        $user = Auth::guard('customer')->user();
        if($request->quant){
            $error = array();
            $success = '';
            foreach($request->quant as $k=>$quant){
                if($quant > 10){
                    $error[] = 'Cart Invalid!';
                    return back()->with($error)->with('error', "Invalid Quantity");
                }
            }
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                $type = $request->type[$k];
                $preference = $request->preference[$k];
                // return $id;
                $cart = Cart::where('id',$id)->where('type',$type)->where('preference',$preference)->first();

//                if ($cart->price == 0 && $cart->amount == 0) {
//                    // Skip free products and continue to the next iteration
//                    request()->session()->flash('error','Can not Update free Product');
//                    return back();
//                    continue;
//                }

                // return $cart;
                // dd($cart);
                if($quant > 0 && $cart) {
                    // return $quant;
                   $stock = Stock::where('product_id',$cart->product_id)->where('warehouse_id',$user->warehouse)->where('is_active',1)->first();
                    if(!$stock || $stock->stocks < 1 || $stock->stocks < $quant){
                       request()->session()->flash('error','Limited Stock Available');
                        return back();
                        ///return back()->with('error','Out of stock, You can add other products.');
                    }


                    //if($cart->product->qty < $quant){
                  //     request()->session()->flash('error','Out of stock');
                  //      return back();
                  //  }
                    //dd($cart->product->qty);
                    $cart->quantity =  $quant;
                    //$cart->quantity = ($cart->product->qty > $quant) ? $quant  : $cart->product->qty;
                    // return $cart;

                    //if ($cart->product->qty <=0) continue;

                    // dd($cart->type);
                    if($cart->preference == "delivery"){
                        if($cart->type == "CASE"){
                            $after_price=($cart->product->delivery_pack-($cart->product->delivery_pack*$cart->product->discount)/100);
                        }else{
                            $after_price=($cart->product->delivery_single-($cart->product->delivery_single*$cart->product->discount)/100);
                        }
                        $cart->amount = $after_price * $quant;
                        // dd($cart->amount);
                    }else{
                        if($cart->type == "CASE"){
                            $after_price=($cart->product->p_price-($cart->product->p_price*$cart->product->discount)/100);
                        }else{
                            $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                        }
                        $cart->amount = $after_price * $quant;
                    }
                    //tax calculation from db if id 1 tax will be apply 20% other wise 0
                    if($cart->vat > 0){
                        $taxamount = $cart->amount*20/100;
                    }else{
                        $taxamount =0;
                    }
                    $cart->vat = $taxamount;
                    //tax calculation end here
                    // dd($cart->amount);
                    // return $cart->price;
//                    if ($cart->price == 0 && $cart->amount == 0){
//                        $success = 'Can not updated free product!';
//                    }else{
                        $cart->save();
                        $success = 'Cart successfully updated!';
//                    }

                }else{
                    $error[] = 'Cart Invalid!';
                }
                $id = '';
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );

    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
        $env = config("msdynamic.app_env");
        $url = config("msdynamic.app_url");

        $user  = Auth::guard('customer')->user();
        if($user == null){
            return  redirect()->route('customer.login');
        }
        $warehouse_id = $user->warehouse;
        if($user != null){
            $branch = Branch::where('email',$user->email)->first();
            $leaves = Leaves::select('date')->where('warehouse_id',$warehouse_id)->where('is_active', 1)->get()->toArray();
            $leave_date = [];
            foreach($leaves as $leave){
                array_push($leave_date,$leave['date']);
            }
            // dd($leave_date);
            if($user->checkout_preference == "delivery"){
                return view('frontend.checkout_delivery',compact('leave_date','warehouse_id','user','env','url'));
            }else{
                return view('frontend.checkout_pickup',compact('leave_date','warehouse_id','user','env','url'));
            }
        }
        $leave_date = [];
        $warehouse_id = 1;
        return view('frontend.checkout_delivery',compact('leave_date','warehouse_id','env','url'));

        // $period = new CarbonPeriod('09:00', '30 minutes', '17:00'); // for create use 24 hours format later change format
        // $slots = [];
        // foreach($period as $item){
        //     array_push($slots,$item->format("h:i A"));
        // }
        // return view('frontend.checkout',compact('slots'));
    }
    public function checkoutDevliveryStep2(Request $request){
        $devliverydata = $request->all();
      //  dd($devliverydata);
       $postcodes= Warehouse::where('id',$request->warehouse_id)->first();
       $postcodewithoutspace= str_replace(' ','',$postcodes->postcodes);
       $postcodes_allowed = explode(',',$postcodewithoutspace);
       $customer_postcode=  str_replace(' ','',$request->post_code);
       if(!in_array($customer_postcode,$postcodes_allowed)){// checking allowed postcode or not
         return redirect()->route('cart')->with([
            'error' => 'Sorry, delivery to your postcode is currently unavailable. We apologize for any inconvenience.',
        ]);
       }
        $env = config("msdynamic.app_env");
        $url = config("msdynamic.app_url");

        $user  = Auth::guard('customer')->user();
        if($user == null){
            return  redirect()->routße('customer.login');
        }
        $warehouse_id = $user->warehouse;
        $weeksdata= Delivery_week::select('*')->where('warehouse_id',$request->warehouse_id)->get();
        $count =4;
        $weeksjump = 0;
        $currentDate = new DateTime();
        $morning8AM = new DateTime('08:00:00');
        $timeDifference = $currentDate->diff($morning8AM);
         $morning8AM->format('H:i:s');
        // Format the time difference
        $hours = $timeDifference->format('%h'); //hours diffrenst before 8 am order ,hours will be 1+ bcz minuts not count
        $currentDayOfWeek = $currentDate->format('N'); 
        //$minutes = $timeDifference->format('%i');
        //$seconds = $timeDifference->format('%s');
        //$currentDateTime = new DateTime();
        $showallavaildates =array();

        for ($days = 1; $days <= $count; $days++) {
            //echo $days;
           
            
            foreach($weeksdata as $item){
                $currentDate = new DateTime();
                $weeksjump.'weekjump';
                $currentDayOfWeek;// N returns the current day of the week (1 = Monday, 7 = Sunday)
            // Calculate the number of days to add to reach the next same days
            $daysToAdd =0;
            if($currentDayOfWeek == $item->delivery_day && $hours <= 5)
            {
                // delivery block date condition will be here
              //echo 'cond1-';
             $daysToAdd = $currentDayOfWeek  + $weeksjump ; // 6 is the numeric representation of Saturday
             //echo '-';
            }elseif($currentDayOfWeek < $item->delivery_day){
               // echo 'condM-';
             $daysToAdd = $item->delivery_day - $currentDayOfWeek  + $weeksjump ; // 6 is the numeric representation of Saturday
               // echo '-';
             //   $daysToAdd = $currentDayOfWeek  + $weeksjump;
            }else{
                // delivery block date condition will be here as well
              // echo '-cond2-';
                $daysToAdd = $item->delivery_day - $currentDayOfWeek + 7 + $weeksjump; // 6 is the numeric representation of Saturday
              // echo '-';
               
            }
           

            // Modify the current date to get the next Saturday
            $currentDate->modify("+$daysToAdd days");

            // Format the next Saturday as a string (e.g., "2023-09-09")
            $nextdeliveryday = $currentDate->format('Y-m-d');

            array_push($showallavaildates,$nextdeliveryday);
            
            }
            $weeksjump = 7+$weeksjump;
        }
            sort($showallavaildates);
           // dd($showallavaildates);
           
           
            // dd($leave_date);
            if($user->checkout_preference == "delivery"){
                return view('frontend.checkout_delivery_Step2',['devliverydata'=>$devliverydata,'datesweeks'=>$showallavaildates,'env'=>$env,'url'=>$url,'user'=>$user]);
            }else{
                return view('frontend.checkout_pickup');
            }
    
    }
    public function slots_generater(Request $request){
        $mytime  = now();

        $time = strtotime($request->date);
        $AjaxDateformat = date('Y-m-d',$time);

        //Day extraction
        $dt = new DateTime($AjaxDateformat);
        $day =  $dt->format('l');
        switch ($day) {
            case 'Monday':
                $query_day = 1;
                break;
            case 'Tuesday':
                $query_day = 2;
                break;
            case 'Wednesday':
                $query_day = 3;
                break;
            case 'Thursday':
                $query_day = 4;
                break;
            case 'Friday':
                $query_day = 5;
                break;
            case 'Saturday':
                $query_day = 6;
                break;
            case 'Sunday':
                $query_day = 7;
                break;
        }

        $currentTime = strtotime($request->currentTime);
        $currentTime= strtotime($request->currentTime)+(60*60);// increse 60 minuts to current time so next slot will be showing accordingly
        $slots = [];
        $warehous_id = $request->warehouse_id;
        $warehouse = Slots::where('warehouse_id',$warehous_id)->where('is_active',1)->where('start_day','<=',$query_day)->where('end_day','>=',$query_day)->first();
        if($warehouse){
            $per_slot_count = $warehouse->per_slot_order;
        }else{
            $per_slot_count = 0;
        }
        $checkObj = Sale::select(DB::raw('COUNT(*) As total'), 'pick_time')->where('pick_date',$request->date)->where('warehouse_id',$warehous_id)->groupBy('warehouse_id')->orderBy('id','DESC')->get()->toArray();
        // dd($checkObj->toArray());
        if($warehouse){
            $period = new CarbonPeriod($warehouse->start_time, $warehouse->duration.' minutes', $warehouse->end_time); // for create use 24 hours format later change format
            // $period = new CarbonPeriod('09:00', '30 minutes', '17:00');
            foreach($period as $item){
                    if($AjaxDateformat == $request->dateTodayInYMD){
                        $slotTime = strtotime($item->format("h:i A"));
                        if($slotTime > $currentTime){
                            if($per_slot_count > 0){
                                $flag = $this->checkSlotCount($checkObj,$per_slot_count,$item);
                                if($flag){
                                    array_push($slots,$item->format("h:i A"));
                                }
                            }else{
                                array_push($slots,$item->format("h:i A"));
                            }
                        }
                    }else{
                        if($per_slot_count > 0){
                            $flag = $this->checkSlotCount($checkObj,$per_slot_count,$item);
                            if($flag){
                                array_push($slots,$item->format("h:i A"));
                            }
                        }else{
                            array_push($slots,$item->format("h:i A"));
                        }
                    }
            }
        }
        if($slots == null){
            return false;
        }
        return json_encode($slots);
    }

    public function checkSlotCount($saleArray, $per_slot_count,$time){
        if(empty($saleArray)){
            return true;
        }
        foreach($saleArray as $sale){
            if(in_array( $time->format("h:i A") , $sale) ){
                if($sale['total'] >= $per_slot_count){
                    return false;
                }
                return true;
            }
            return true;
        }
    }

    public function ajax_cart(){
        $items = [];
        $cart_product = Helper::getAllProductFromCart();
        $cart_product_count = count($cart_product);
        if($cart_product_count > 0){
            $html = '';
            foreach(Helper::getAllProductFromCart() as $data){

            //dd($data->product);
                $photo=explode(',',$data->product['image']);
                $link = "/product-detail/".$data->product['title'];
                // dd($photo[0]);

                $html .= '<div class="flex items-center border-b pb-2 mb-3">';
                $html .= '<div class="relative w-[50px] h-[50px]">';
                $html .= '<a href="/cart-delete/'.$data->id.'" class="absolute -top-[8px] left-0 w-[16px] h-[16px] flex items-center justify-center text-white" title="Remove this item">';
                // $html .= '<a href="{{route(\'cart-delete\','.$data->id.')}}" class="absolute -top-[8px] left-0 w-[16px] h-[16px] flex items-center justify-center text-white" title="Remove this item">';
                $html .= '<i class="fa fa-remove"></i>';
                $html .= '</a>';
                $html .= '<a class="w-[50px] h-[50px] rounded-full overflow-hidden" href="#">';
                $photo[0] = str_replace('storage/','',$photo[0]);
                $html .= '<img src="'.image_url('storage/'.$photo[0]).'" class="w-full" alt="'.$photo[0].'">';
                // $html .= '<img src="'.{{asset("storage/")}}.'" class="w-full" alt="'.$photo[0].'">';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '<div class="ml-3">';
                $html .= '<h4 class="text-[14px] font-semibold mb-1"><a href="'.$link.'"  target="_blank">'.$data->product['title'].'</a></h4>';
                $html .= '<p class="text-[12px]">'.$data->quantity.' x - <span class="amount">£'.number_format($data->price,2).'</span></p>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $totalCartPrice = number_format(Helper::totalCartPrice(),2);
            $items['totalCartPrice'] = $totalCartPrice;
            $items['html'] = $html;
            $items['cart_product_count'] =$cart_product_count;
            $items['check'] =  true;
            return $items;
        }else{
            $items['check'] =  false;
            return $items;
        }

    }

    public function emptyCartAndChangePreference(){
        $user_id = \Auth::guard('customer')->user()->id;
        $delete = Cart::where('user_id', $user_id)->where('order_id', null)->delete();
        return $delete;
    }

    public function ajaxUpdate(Request $request){
        $qty = $request->qty;
        $user_id = $request->user_id;
        $user = Customer::where('id',$user_id)->first();
        $product_id = $request->product_id;
        $preference = $request->preference;
//        $cart = Cart::where('user_id',$user_id)->where('product_id', $product_id)->where('preference',$preference)->whereNull('order_id')->first();
        $cart = Cart::where('user_id',$user_id)->where('product_id', $product_id)->where('preference',$preference)->whereNull('order_id')->whereNull('cart_id')->first();
        if (!$cart->price == 0 && !$cart->amount == 0){
            if($qty > 0 && $cart) {
                // return $quant;
                $stock = Stock::where('product_id',$cart->product_id)->where('warehouse_id',$user->warehouse)->where('is_active',1)->first();
                if(!$stock || $stock->stocks < 1 || $stock->stocks < $qty){
                    request()->session()->flash('error','Limited Stock Available');
                    return back();

                }
                $cart->quantity =  $qty;
                if($cart->preference == "delivery"){
                    if($cart->type == "CASE"){
                        $after_price=($cart->product->delivery_pack-($cart->product->delivery_pack*$cart->product->discount)/100);
                        $net_price = $cart->product->delivery_pack;
                    }else{
                        $after_price=($cart->product->delivery_single-($cart->product->delivery_single*$cart->product->discount)/100);
                        $net_price = $cart->product->delivery_single;
                    }
                    $cart->amount = $after_price * $qty;
                }else{
                    if($cart->type == "CASE"){
                        $after_price=($cart->product->p_price-($cart->product->p_price*$cart->product->discount)/100);
                        $net_price = $cart->product->p_price;
                    }else{
                        $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                        $net_price = $cart->product->price;
                    }
                    $cart->amount = $after_price * $qty;
                }
                //tax calculation from db if id 1 tax will be apply 20% other wise 0
                if($cart->vat > 0){
                    $taxamount = $cart->amount*20/100;
                }else{
                    $taxamount =0;
                }
                $cart->vat = $taxamount;

                $cart->save();
                $success = 'Cart successfully updated!';

                $amount = $cart->vat + $cart->amount;

                $product = Product::with('freeProduct')->where('id', $product_id)->first();

                $freeCartFlag = false;
                $deleteCartFreeProFlag = false;

                if(isset($product->freeProduct) && count($product->freeProduct) > 0) {
                    foreach ($product->freeProduct as $freeProduct) {
                        if ($freeProduct->product_id === $product->id) {
                            $cart_free_pro = Cart::where('user_id',$user_id)->where('product_id', $product_id)->where('preference',$preference)->whereNull('order_id')->whereNull('cart_id')->first();
                            $delete_cart_free_pro = Cart::where('user_id', $user_id)
                                ->where('product_id', $freeProduct->free_product_id)
                                ->where('preference', $preference)
                                ->where('cart_id', $cart_free_pro->id)
                                ->whereNull('order_id')
                                ->first();
//                            foreach ($delete_cart_free_prod as $delete_cart_free_pro){
//                            if ($freeProduct->quantity === $cart_free_pro->quantity && !$delete_cart_free_pro) {
                                if ($cart_free_pro->quantity >= $freeProduct->quantity && !$delete_cart_free_pro) {
                                    $freeCart = new Cart;
                                    $freeCart->user_id = \Auth::guard('customer')->user()->id;
                                    $freeCart->cart_id = $cart->id;
                                    $freeCart->product_id = $freeProduct->free_product_id;
                                    $freeCart->product_ms_id = $freeProduct->product->ms_id;
                                    $freeCart->quantity = 1;
                                    $freeCart->type = 'SINGLE';
                                    $freeCart->preference = $request->preference;
                                    $freeCart->amount = '0';
                                    $freeCart->vat = '0';
                                    $freeCart->save();
                                    $freeCartFlag = true;

                                }else{
                                    if ($delete_cart_free_pro && $cart_free_pro->quantity < $freeProduct->quantity) {
                                        $delete_cart_free_pro->delete();
                                        $deleteCartFreeProFlag = true;
                                    }
                                }
//                            }
                        }
                    }
                }

                return response()->json([
                    "success" => true,
                    "cart_amount" => number_format($amount,2),
                    "cart_vat" => number_format($cart->vat,2),
                    "net_price" => number_format($net_price,2),
                    "cart_subtotal" => number_format(Helper::totalCartPrice(),2),
                    "total_vart" => number_format(Helper::totalCartVatPrice(),2),
                    "grand_total" => number_format(Helper::totalCartPrice()+Helper::totalCartVatPrice(),2),
                    "message" => $success,
                    "freeCart" => $freeCartFlag,
                    "cart_free_pro_delete" => $deleteCartFreeProFlag,

                ]);
            }else{
                $error = 'Cart Invalid!';
                return response()->json([
                    "success" => false,
                    "message" => $error
                ]);
            }
        }
    }


}
