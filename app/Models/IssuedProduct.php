<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuedProduct extends Model
{
    protected $guarded = ['id'];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function issuedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function scopeDistrictQuery($query)
    {
        return $query->join('facilities', 'facilities.id', '=', 'issued_products.facility_id')
            ->join('districts', 'districts.id', '=', 'facilities.district_id')
            ->where('district_id', auth()->guard('district_admin')->user()->district_id);
    }
}
