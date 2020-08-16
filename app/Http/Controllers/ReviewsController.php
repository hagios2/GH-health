<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductReviewRequest;
use App\Http\Requests\ShopReviewRequest;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ShopReviewResource;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['storeShopReview', 'storeProductReview']);
    }
    
    public function fetchShopReviews(Merchandiser $merchandiser)
    {
        $shop_reviews = $merchandiser->shopReview;

        return ShopReviewResource::collection($shop_reviews);
    }


    public function storeShopReview(Merchandiser $merchandiser, ShopReviewRequest $request)
    {
        $merchandiser->addProductReview($request->validated());

        return response()->json(['status' => 'saved']);
    }


    public function fetchProductReviews(Product $product)
    {
        $product_reviews = $product->productReview;

        return ProductReviewResource::collection($product_reviews);
    }


    public function storeProductReview(Product $product, ProductReviewRequest $request)
    {
        $product->addProductReview($request->validated());

        return response()->json(['status' => 'saved']);
    }
}
