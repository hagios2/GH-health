<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueProductOutRequest;
use App\Http\Resources\IssuedOutProductResource;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Http\Resources\DetailedProductResource;
use App\Http\Resources\ProductResource;


class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function fetchProducts()
    {
        $products = Product::query()->facilityProduct()->lateest()->paginate(10);

        return new ProductResource($products);
    }

    public function getProductDetails(Product $product)
    {
        return new DetailedProductResource($product);
    }

    public function issueOutProduct(Product $product, IssueProductOutRequest $request)
    {
        $validated_product_data = $request->validated();

        $validated_product_data['issued_by'] = auth()->guard('api')->id();

        $product->issueOutProduct($validated_product_data);

        return response()->json(['message' => "issued out successfully"], 201);
    }

    public function viewIssuedOutProduct(Product $product)
    {
        $issued_out_product = IssuedProduct::query()->where('product_id', $product->id)->latest()->paginate();

        return new IssuedOutProductResource($issued_out_product);
    }

}
