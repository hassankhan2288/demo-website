<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class RegisterController extends Controller
{
    //
    public function products()
    {
        $products = Product::with('category', 'brand', 'unit')
                        //->offset($start)
                        ->where('is_active', true)
                       // ->limit($limit)
                       // ->orderBy($order,$dir)
                        ->get();

                        dd($products);
    }
}
