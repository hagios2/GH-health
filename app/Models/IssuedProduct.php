<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuedProduct extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
