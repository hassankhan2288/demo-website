<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeProduct extends Model
{
    protected $fillable = ['product_id', 'free_product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'free_product_id');

    }

}
