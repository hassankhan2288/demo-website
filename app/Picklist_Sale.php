<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picklist_Sale extends Model
{
	protected $table = 'picklist_sales';
    protected $fillable =[
        "sale_id", "product_id", "product_names", "product_qty", 'user_name', "user_id", "ref_no", "picked_by", "pick_date"
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
