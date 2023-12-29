<?php

namespace App;
use Auth;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        "name", "slug" ,"description","allergens","code", "type", "barcode_symbology", "brand_id",
         "category_id", "unit_id", "purchase_unit_id", "sale_unit_id", "cost", "p_price" ,"price",
          "qty", "alert_quantity", "daily_sale_objective", "promotion", "promotion_price", 
          "starting_date", "last_date", "tax_id", "tax_method", "image", "file", "is_embeded", 
          "is_batch", "is_variant", "is_diffPrice", "is_imei", "featured", "product_list", 
          "variant_list", "qty_list", "price_list", "product_details", "variant_option",
           "variant_value", "is_active", "pack_size", "collection", "delivery", "packing_info", "ingredients", "ms_id"
    ];

    public function pricing()
    {
        return $this->hasMany(ProductPricingManagement::class,'product_id');
        
    }
    public function web_price()
    {
        if( Auth::guard('customer')->user()){
            $warehouseid= \Auth::guard('customer')->user()->warehouse;
        }else{
            $warehouseid=7;
        }
        return $this->hasOne(Product_price::class,'product_ms_id','ms_id')->where('warehouse_id',$warehouseid);
        
    }
    public function customerPrice()
    {
        return $this->hasOne(customer_price::class, 'product_ms_id', 'ms_id')->where('customer_id',\Auth::guard('customer')->user()->id);
    }
//    public function getFullpriceAttribute()
//    {
//        if ($this->customerPrice) {
//            return $this->customerPrice;
//        }elseif($this->web_price) {
//            return $this->web_price;
//        }else{
//            return null; // Return null or any default value if neither price is found.
//        }
//
//
//    }
    public function getFullpriceAttribute()
    {
       
        $webPrice = $this->web_price()->first();
        
        if (Auth::guard('customer')->user() && $this->customerPrice()->first()) {
            $customerPrice = $this->customerPrice()->first();
            return $customerPrice;
         } elseif ($webPrice) {
            return $webPrice;
        } else {
            return null; // Return null or any default value if neither price is found.
        }
    }
    public function wishlists(){

        return $this->belongsToMany('App\Customer', 'wishlists', 'product_id', 'user_id');
    }

    public function stock(){
        return $this->hasMany('App\Stock');
    }

    // public function category()
    // {
    // 	return $this->belongsTo('App\Category');
    // }
    public function categories()
    {
   	return $this->belongsToMany(Category::class);
        // return $this->belongsTo(Category::class, 'category_id');

    }

    public function tax()
    {
        return $this->belongsTo('App\Tax');
    }

    public function brand()
    {
    	return $this->belongsTo('App\Brand');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function variant()
    {
        return $this->belongsToMany('App\Variant', 'product_variants')->withPivot('id', 'item_code', 'additional_cost', 'additional_price');
    }

    public function scopeActiveStandard($query)
    {
        return $query->where([
            ['is_active', true],
            ['type', 'standard']
        ]);
    }

    public function scopeActiveFeatured($query)
    {
        return $query->where([
            ['is_active', true],
            ['featured', 1]
        ]);
    }

    public static function getProductBySlug($slug){
        return Product::where('slug',$slug)->orderBy('id','DESC')->first();
    }

    public function freeProduct()
    {
        return $this->hasMany(FreeProduct::class,'product_id');

    }
}
