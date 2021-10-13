<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use App\Http\Requests\IssueProductOutRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\IssuedOutProductResource;
use App\Http\Resources\SingleIssuedOutProductResource;
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

    public function createProduct(ProductRequest $request): \Illuminate\Http\JsonResponse
    {
        auth()->user()->facility->addProduct($request->validated());

        return response()->json(['message' => 'product created'], 201);

    }

    public function fetchProducts(): ProductResource
    {
        $products = Product::query()->facilityProduct()->latest()->paginate(10);

        return new ProductResource($products);
    }

    public function getProductDetails(Product $product): DetailedProductResource
    {
        return new DetailedProductResource($product);
    }

    public function updateProduct(Product $product, ProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $product->update($request->validated());

        return response()->json(['message' => 'product updated']);
    }

    public function deleteProduct(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'product deleted']);
    }

    public function issueOutProduct(Product $product, IssueProductOutRequest $request): \Illuminate\Http\JsonResponse
    {
        if($product->quantity === 0)
        {
            return response()->json(['message' => "Product is out of Stock"], 401);
        }

        $validated_product_data = $request->validated();

        $validated_product_data['issued_by'] = auth()->guard('api')->id();

        $product->issueOutProduct($validated_product_data);

        return response()->json(['message' => "issued out successfully"], 201);
    }

    public function updateIssueOutProduct(IssuedProduct $issuedProduct, IssueProductOutRequest $request): \Illuminate\Http\JsonResponse
    {
        $product = Product::find($request->id);

        if($product->quantity === 0)
        {
            return response()->json(['message' => "The selected product is out of Stock"], 401);
        }

        if($issuedProduct->product && (int) $request->product_id === $issuedProduct->product_id)
        {
            $issuedProduct->product->update(['quantity' => $issuedProduct->quantity_before_issued_out]);
        }

        $validated_product_data = $request->validated();

        $validated_product_data['issued_by'] = auth()->guard('api')->id();

        $validated_product_data['quantity_before_issued_out'] = $product->quantity;

        $validated_product_data['quantity_after_issued_out'] = $product->quantity - (int) $request->quantity;

        $validated_product_data['facility_id'] = $product->facility_id;

        $issuedProduct->update($validated_product_data);

        return response()->json(['message' => "issued out successfully"], 201);
    }

    public function viewIssuedOutProduct(): IssuedOutProductResource
    {
        $issued_out_product = IssuedProduct::query()->where('facility_id', auth()->user()->facility->id)->latest()->paginate(10);

        return new IssuedOutProductResource($issued_out_product);
    }

    public function fetchASingleIssuedCase(IssuedProduct $issuedProduct): SingleIssuedOutProductResource
    {
        return new SingleIssuedOutProductResource($issuedProduct);
    }

}
