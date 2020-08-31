<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Merchandiser;
use App\User;
use App\Http\Resources\AdminViewShopResource;
use App\Http\Resources\AdminViewUsersResource;
use App\Http\Resources\ShopReviewResource;
use App\Http\Resources\DetailedProductResource;
use App\Http\Resources\MerchandiserResource;
use App\ShopReview;
use App\ProductReview;
use App\Product;
use App\Http\Resources\ProductReviewResource;


class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function getUsers()
    {
        return new AdminViewUsersResource(User::paginate(20));
    }

    public function blockUser(User $user)
    {

       $user->update(['isActive' => false]);

       return response()->json(['status' => 'blocked']);

    }


    public function unblockUser(User $user)
    {

       $user->update(['isActive' => true]);

       return response()->json(['status' => 'unblocked']);

    }


    public function getShops()
    {

        return new AdminViewShopResource(Merchandiser::paginate(20));

    }


    public function ShopDetails(Merchandiser $shop)
    {
        return new MerchandiserResource($shop);
    }

    public function productDetails(Product $product)
    {
       
        return new DetailedProductResource($product); 
    }


    public function deleteShop(Merchandiser $shop)
    {
        $products = $shop->product;

        $products->map(function($product){

            $this->deleteProductReviews($product);

            $this->deleteProductImages($product);

            $product->delete();

        });

        $shop->delete();

        return response()->json(['status' => 'shop deleted']);
    }


    public function deleteProduct(Product $product)
    {

        $this->deleteProductReviews($product);

        $this->deleteProductImages($product);

        $product->delete();

        return response()->json(['status' => 'product deleted']);
    }

    public function deleteProductReviews(Product $product)
    {

        if($product->review)
        {
            $product->review->map(function($review){

                $review->delete();
            });
        }
    }

    public function deleteProductImages(Product $product)
    {
        if($product->image)
        {
            $product->image->map(function($image){

                #delete file

                $image->delete();
            });
        }
    }


    public function getShopReviews(Merchandiser $shop)
    {

        return new ShopReviewResource(ShopReview::where('merchandiser_id', $shop->id)->paginate(20));

    }

    public function getProductReviews(Product $product)
    {

        return new ProductReviewResource(ProductReview::where('product_id', $product->id)->paginate(20));

    }


    public function deleteProductReview(ProductReview $review)
    {

       $review->delete();

       return response()->json(['status' => 'deleted']);

    }

    public function deleteShopReview(ShopReview $review)
    {

       $review->delete();

       return response()->json(['status' => 'deleted']);

    }


    public function deleteUser(User $user)
    {
        if($user->product)
        {
            $user->product->map(function($product){

                $this->deleteProductReviews($product);

                $this->deleteProductImages($product);
        
                $product->delete();

            });
        }

        $user->delete();

        return response()->json(['status' => 'user deleted']);
    }


}
