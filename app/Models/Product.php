<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @method static where(string $string, string $string1)
 */
class Product extends Model implements Searchable
{
    protected $guarded = ['id'];

    public function getSearchResult(): SearchResult
    {
       $url = route('product.details', $this->id);

        $data = [
            'product_images' => $this->image,
            'avg_rating' => $this->review->avg('rating')
        ];

        return new SearchResult(
            $this,
            json_encode($data),
            $url
        );
    }


    public function image()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function addProductImage($image)
    {
        $this->image()->create($image);
    }

    public function review()
    {
        return $this->hasMany('App\ProductReview');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function productReport()
    {
        return $this->hasMany('App\ProductReport');
    }

    public function paidProduct()
    {
        return $this->hasOne(PaidProduct::class);
    }


    public function addPaidProduct($paid_product)
    {
        $this->paidProduct()->create($paid_product);
    }


    public function scopeFacilityProduct($query)
    {
        $query->where('facility_if', auth()->guard('api')->user()->facility_id);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issuedProduct()
    {
        return $this->hasMany(IssuedProduct::class);
    }


    public function issueOutProduct($issued_product)
    {
        $issued_product['quantity_before_issued_out'] = $this->quantity;

        return $this->issuedProduct()->create($issued_product);
    }

    public function scopeDistrictProducts($query)
    {
        return $query->join('facilities', 'facilities.id', '=', 'issued_products.facility_id')
            ->join('districts', 'districts.id', '=', 'facilities.district_id')
            ->where('district_id', auth()->guard('district_admin')->user()->district_id);
    }
}
