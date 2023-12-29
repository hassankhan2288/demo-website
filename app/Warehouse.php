<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable =[

        "name", "phone", "email", "address", "is_active", "delivery_charges","amount_over"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    	
    }

    public function leaves(){
        return $this->hasMany('App\Leaves');
    }
}
