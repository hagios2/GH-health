<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static create(array $user_data)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'facility_id', 'email_verified_at', 'isActive', 'last_login', 'must_change_password'
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


    public function getJWTCustomClaims(): array
    {
        return [];
    }


    public function product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Product');
    }


    public function addFollowing($following)
    {
        $this->following()->create($following);
    }

    public function facility(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Facility::class);
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


    public function emailVerified(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\VerifyEmail');
    }

    public function addEmailToken($token): \Illuminate\Database\Eloquent\Model
    {
        return $this->emailVerified()->create($token);
    }


    public function shopReview()
    {
        return $this->hasOne('App\ShopReview');
    }


    public function addShopReview($review)
    {
        $this->shopReview()->create($review);
    }


    public function productReview(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\ProductReview');
    }


    public function addProductReview($review)
    {
        $this->productReview()->create($review);
    }


    public function shopReport(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\ShopReport');
    }


    public function addShopReport($report)
    {
        $this->shopReport()->create($report);
    }


    public function productReport()
    {
        return $this->hasOne('App\ProductReport');
    }


    public function addProductReport($report)
    {
        $this->productReport()->create($report);
    }


    public function sellersBillingDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BillingDetail::class);
    }

    public function addSellersBillingDetail($billing_detail): \Illuminate\Database\Eloquent\Model
    {
        return $this->sellersBillingDetail()->create($billing_detail);
    }

    public function sellersPayment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SellersPayment::class, 'user_id');
    }

    public function addPayment($payment)
    {
        $this->sellersPayment()->create($payment);
    }


}
