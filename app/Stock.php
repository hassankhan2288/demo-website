<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "stock";
    protected $fillable =[

        "product_id", "warehouse_id", "stocks", "is_active", "price"
    ];

    public function product()
    {
    	return $this->belongsTo('App\Product');
    	
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
