<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Victim extends Model
{
    protected $guarded = ['id'];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function scopeDistrictVictims($query)
    {
       return $query->where('district_id', auth()->guard('district_admin')->id());
    }
}
