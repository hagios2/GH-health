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


    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function merchandiser()
    {
        return $this->belongsTo('App\Merchandiser');
    }


    public function review()
    {
        return $this->hasMany('App\ProductReview');
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


}
