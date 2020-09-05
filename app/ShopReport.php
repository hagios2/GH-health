<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopReport extends Model
{
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo('App\Merchandiser');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    

}
