<?php

namespace App;

use App\Notifications\MailResetPasswordTokenBranch;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Branch extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'branches';

    protected $fillable = [
        'user_id','name','email','city','ms_number','warehouse','phone','postal_code','address','platform','password','business_type','business_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getwarehouse()
    {
    	return $this->belongsTo('App\Warehouse','warehouse');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function sale(){
        return $this->hasMany('App\Sale');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordTokenBranch($token));
    }
}
