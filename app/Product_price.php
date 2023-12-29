<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_price extends Model
{
    use HasFactory;
    protected $fillable =[
    "p_price" ,"price", "product_ms_id","delivery_pack","delivery_single",'wharehous_id'
    ];
    
    public function products_web()
    {
        return $this->belongsTo(Product::class,'ms_id');
    }
    public function warehouse() {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
    
}
