<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $table = "leaves";
    protected $fillable =[

        "warehouse_id","name", "date", "is_active"
    ];

    // public function product()
    // {
    // 	return $this->belongsTo('App\Product');
    	
    // }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
