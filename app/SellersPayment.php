<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class SellersPayment extends Model
{
    protected $guarded = ['id'];

    public function  user()
    {
        return $this->belongsTo(User::class);
    }
}
