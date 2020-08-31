<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductReviewRequest;
use App\Http\Requests\ShopReviewRequest;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ShopReviewResource;
use App\Product;
use App\Merchandiser;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['storeShopReview', 'storeProductReview']);
    }
    
    public function fetchShopReviews(Merchandiser $merchandiser)
    {
        $shop_reviews = $merchandiser->review;

        return response()->json([
            
            'average_rating' => $shop_reviews->rating->average(),

            'product_reviews' => ShopReviewResource::collection($shop_reviews)
        
        ]);

    }


    public function storeShopReview(ShopReviewRequest $request)
    {
        auth()->guard('api')->user()->addShopReview($request->validated());

        return response()->json([
            
            'status' => 'saved',
            
            'name' => auth()->guard('api')->user()->name

        ]);
    }


    public function fetchProductReviews(Product $product)
    {
        $product_reviews = $product->review;

        return response()->json([
            
            'average_rating' => $product_reviews->rating->average(),

            'product_reviews' => ProductReviewResource::collection($product_reviews)
        
        ]);

    }


    public function storeProductReview(ProductReviewRequest $request)
    {
        auth()->guard('api')->user()->addProductReview($request->validated());

        
        return response()->json([
            
            'status' => 'saved',
            
            'name' => auth()->guard('api')->user()->name

        ]);
    }
}