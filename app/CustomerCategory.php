<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Category;
class CustomerCategory extends Model
{
    protected $table = 'customer_categories';
    protected $fillable =[

        "name", 'image', "parent_id", "is_active", "c_id"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
    public function producthome()
    {
        return $this->hasMany('App\Product')->limit(10);

    }
    public static function getAllParentWithChild(){
        return CustomerCategory::where('status','active')->whereNull('parent_id')->orderBy('name','ASC')->get();
    }
    public static function getProductByCat($slug){
         //dd($slug);
        $products = Product::where('category_id',$slug)->get();
       return $products;
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }

}
