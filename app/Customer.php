<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;


class Customer extends Authenticatable {

    use Notifiable, HasRoles, HasApiTokens;
    
    protected $table = 'customers';
    protected $fillable =[
        "customer_group_id", "user_id", "name", "company_name",
        "email","password" ,"phone_number", "tax_no", "address","address_2","address_3", "city",
        "state", "postal_code", "country", "points", "deposit", "warehouse","expense", "is_active","business_type","business_name"
    ];

    public function customerGroup()
    {
        return $this->belongsTo('App\CustomerGroup');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function sale(){
        return $this->hasMany('App\Sale');
    }
    public function discountPlans()
    {
        return $this->belongsToMany('App\DiscountPlan', 'discount_plan_customers');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
    public function getwarehouse()
    {
    	return $this->hasOne('App\Warehouse','warehouse','id');
    }
    public function getAdressViaAPI($code){
        $response = new Response(Http::get('https://api.getAddress.io/location/'.$code.'?api-key=ZptSRYXSCkq0HrUlrREwGQ39578'));
        if($response->status() == 200){
            $response = json_decode($response);
            if(isset($response->suggestions[0]->location)){
                return $response->suggestions[0]->location;
            }
        }
        return false;
        // $response = Http::get('https://api.getAddress.io/location/'.$code.'?api-key=ZptSRYXSCkq0HrUlrREwGQ39578');
    }
}
