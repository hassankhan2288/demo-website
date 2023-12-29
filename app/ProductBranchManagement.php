<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class ProductBranchManagement extends Model
{
    protected $table = "product_branch_managements";

    protected $fillable = ['product_id', 'user_id'];

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    	
    }
}
