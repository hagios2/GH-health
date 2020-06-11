<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];


    public function image()
    {
        return $this->hasMany('App\ProductImage');
    }


    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function merchandiser()
    {
        return $this->belongsTo('App\Merchandiser');
    }

}
