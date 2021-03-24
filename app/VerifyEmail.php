<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class VerifyEmail extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\User', 'email');
    }


    public function merchandiser()
    {
        return $this->belongsTo('App\Merchandier', 'email');
    }


}
