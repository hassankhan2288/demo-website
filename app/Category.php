<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class Category extends Model
{
    protected $fillable =[

        "name", 'image', "parent_id", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }

    public function sub()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function producthome()
    {
        return $this->hasMany('App\Product')->limit(10);

    }
    public static function getAllParentWithChild(){
        return Category::where('status','active')->whereNull('parent_id')->orderBy('name','ASC')->get();
    }
    public static function getProductByCat($slug){
         //dd($slug);
        $products = Product::where('category_id',$slug)->get();
       return $products;
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }

    public function getParentCategory($id){
        $cat = Category::where('id',$id)->first();
        $parent_category = Category::where('id',$cat->parent_id)->first();
        return $parent_category;
    }

}
