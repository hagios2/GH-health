<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Product;
use App\Category;
use App\User;
use App\Merchandiser;
use App\Http\Resources\AllShopsResource;
use App\Http\Resources\CampusShopsResource;
use App\Http\Resources\DetailedProductResource;
use App\Http\Resources\MerchandiserResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryProductResource;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['saveCart', 'getCart']);
    } 


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
    public function index(Category $category)
    {
/* 
        $products = $categories->map(function($category){

            return $category->product->reverse()->take(4);

        }); */


        return new ProductResource(Product::where('category_id', $category->id)->latest()->take(4)->get());

        
    }


    public function saveCart(User $user, Request $request)
    {

       $cart = $request->validate([
       
            'cart' => 'nullable',
        ]);

        $user->addToCart(json_encode($cart['cart']));

        return response()->json(['status' => 'cart saved']);
    }


    public function getCart()
    {
        $cart = auth()->user()->cart->where('status', 'in cart')->reverse()->first();

        return new CartResource($cart);
    } 


    public function fetchShops()
    {

        return new AllShopsResource(Merchandiser::paginate(8));
    }   


    public function fetchShopsProduct(Merchandiser $shops)
    {
        $products = $shops->product;

        return new ProductResource($products);
    }


    public function merchandiserDetails(Merchandiser $shop)
    {
        return new MerchandiserResource($shop);
    }



    public function campusShopAndProduct(Campus $campus)
    {
        $shops = $campus->merchandiser;

        $categories = Category::all();

        $cat_products = $categories->map(function($category) use ($campus) {

            $all_cat_products = $category->product;

            $products = $all_cat_products->map(function($product) use ($campus){

                if($product->user)
                {
                    if($product->user->campus_id == $campus->id){

                        return new CategoryProductResource($product);
                    }
                
                }else if($product->merchandiser){

                    if($product->merchandiser->campus_id == $campus->id){

                        return new CategoryProductResource($product);
                    }

                }
            });

            return [$category->category => $products]; 
        });

        return response()->json(['shops' => CampusShopsResource::collection($shops), $cat_products]);

    }



}
