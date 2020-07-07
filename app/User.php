<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'campus_id'
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


    public function product()
    {
        return $this->hasMany('App\Product');
    }


    public function following()
    {
        return $this->hasMany('App\Follower');
    }

    public function campus()
    {
        return $this->belongsTo('App\Campus');
    }


    public function cart()
    {
        return $this->hasMany('App\Cart');
    }


    public function addToCart($cart)
    {
        $existing_cart = $this->cart->where('status', 'in cart')->reverse()->first();

        if($existing_cart)
        {
            $existing_cart->update(['cart' => $cart]);
        
        }else{

            $this->cart()->create(['cart' => $cart]);
        }


    }
}
