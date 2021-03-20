<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $campus_id)
 */
class Campus extends Model
{

    protected $fillable = ['campus'];


    public function merchandiser()
    {
        return $this->hasMany('App\Merchandiser');
    }


    public function users()
    {
        return $this->hasMany('App\user');
    }


    public function addCarouselImage($image)
    {
        $this->carousel()->create($image);
    }


    public function carousel()
    {
        return $this->hasMany('App\CarouselControl', 'campus_id');
    }

    public function userCampusProduct()
    {
        return $this->hasManyThrough(Product::class, User::class);
    }

    public function shopCampusProduct()
    {
        return $this->hasManyThrough(Product::class, Merchandiser::class);
    }
}
