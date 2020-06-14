<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Http\Resources\DetailedProductResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

/*     public function __construct()
    {
        $this->middleware('auth:api');
    } */


    public function getCategories()
    {

        return CategoryResource::collection(Category::all('id', 'category'));

    }




    public function getCategorysProduct(Category $category)
    {
        
        return new ProductResource(Product::where('category_id', $category->id)->paginate(16));

    }


    
    public function getProductDetails(Product $product)
    {

    
        return new DetailedProductResource($product);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();


        $products = $categories->map(function($category){

            return $category->product->reverse()->take(4);

        });


        return ProductResource::collection($products);

        
    }




}
