<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','description','photo','status','type','link'];

    public function getPhotoAttribute($value){
        $value = image_url($value);
        return $value;
    }
}
