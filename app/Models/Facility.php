<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Facility extends Model
{
    protected $guarded = ['id'];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function addProduct($product_data): Model
    {
        $product_data['user_id'] = auth()->id();

        return $this->product()->create($product_data);
    }
}
