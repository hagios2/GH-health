<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    protected $guarded = ['id'];

    public function getSearchResult(): SearchResult
    {
       $url = route('product.details', $this->id);

        return new SearchResult(
           $this,
           $this->product_name,
           json_encode(['product_image' => ProductImage::query()->where('product_id', $this->id)->first()]),
           $url
        );
    }


    public function image()
    {
        return $this->hasMany('App\ProductImage');
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


}
