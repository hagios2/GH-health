<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictAdmin extends Model
{
    protected $guarded = ['id'];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
