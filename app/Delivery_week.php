<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery_week extends Model
{
    use HasFactory;
    protected $fillable =[

        "warehouse_id","delivery_day", "limit_orders", "is_active"
    ];
    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
