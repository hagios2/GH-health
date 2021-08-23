<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Victim extends Model
{
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
