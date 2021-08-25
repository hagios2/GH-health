<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Facility extends Model
{
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function product()
    {
        $this->hasMany(Product::class);
    }

    public function addProduct($product_data)
    {
        $product_data['user_id'] = auth()->id();

        return $this->product()->create($product_data);
    }
}
