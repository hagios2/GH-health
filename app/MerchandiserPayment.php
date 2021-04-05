<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, int|string|null $id)
 */
class MerchandiserPayment extends Model
{
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo(Merchandiser::class);
    }
}
