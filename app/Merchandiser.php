<?php

namespace App;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchandiser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'email', 'password', 'company_description', 'campus_id', 'phone', 'avatar', 'cover_photo', 'shop_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function campus()
    {
        return $this->belongsTo('App\Campus');
    }


    public function product()
    {
        return $this->hasMany('App\Product');
    }


    public function followers()
    {
        return $this->hasMany('App\Follower');
    }

    

    public function shopType()
    {
        return $this->belongsTo('App\ShopType');
    }


    public function review()
    {
        return $this->hasMany('App\ShopReview');
    }

}
