<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{ 
    protected $fillable =[
        "payment_token","reference_no", "user_id", "cash_register_id", "customer_id", "branch_id", "biller_id", "item", "total_qty", "total_discount", "total_tax", "total_price", "order_tax_rate", "order_tax", "order_discount_type", "order_discount_value", "order_discount", "coupon_id", "coupon_discount", "shipping_cost", "grand_total", "sale_status", "payment_status", "paid_amount", "document", "sale_note", "staff_note",'first_name','last_name','country','post_code','address1','address2','address3','phone','email','status','order_type','delivery_date','pick_time','pick_date', "created_at","warehouse_id","delivery_charges"
    ];
    //address1 is delivery address
    //address2 is shipping address
    //address3 is delivery address 2 (if any)

    public function getSaleStatusAttribute($value){
        switch ($value) {          
            case 1:
                $value = 'Completed';
                return $value;
                break;
            case 2:
                $value = 'Pending';
                return $value;
                break;
        }
    }

    public function getGrandTotalAttribute($value){
        $value = str_replace(',','',$value);
        // dd($value);
        return $value;
    }

    public function items()
    {
        return $this->hasMany('App\Product_Sale');
    }

    public function biller()
    {
    	return $this->belongsTo('App\Biller');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function checkSlotsAvailability($warehouse_id, $slot, $date){
        $per_slot_order = Slots::select('per_slot_order')->where('warehouse_id',$warehouse_id)->where('is_active', 1)->first();
        $slots = Sale::where('warehouse_id', $warehouse_id)->where('pick_date',$date)->where('pick_time',$slot)->get();
        if($slots->count() >=  $per_slot_order->per_slot_order){
            return false;
        }
        return true;
    }
}
