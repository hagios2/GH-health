<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $guarded = ['id'];


    public function shopReview()
    {
        return $this->hasMany('App\ShopReview');
    }

}
