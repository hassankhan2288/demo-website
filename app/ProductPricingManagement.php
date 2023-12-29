<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\CustomerCategory;
class ProductPricingManagement extends Model
{
    protected $table = "product_pricing_managements";

    protected $fillable = ['product_id', 'user_id','product_ms_id','p_price','price'];

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    	
    }

    public function categ()
    {
    	return $this->belongsTo(CustomerCategory::class, 'cate');
    	
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
