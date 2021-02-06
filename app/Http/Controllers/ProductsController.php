<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Helpers\CollectionHelper;
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
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['saveCart', 'getCart']);
    }

    public function getCategories()
    {
        return CategoryResource::collection(Category::orderBy('id', 'asc')->get(['id', 'category']));
    }

    public function getCategorysProduct(Category $category, Request $request)
    {
        if($request->has('campus_id'))
        {
            $products = DB::table('products')
                ->join('users', function ($join) use ($request) {
                    $join->on('users.id', '=', 'products.user_id')
                        ->where('users.campus_id', '=', $request->campus_id);
                })
                ->join('merchandisers', function($join) use ($request){
                    $join->on('merchandisers.id', '=', 'products.merchandiser_id')
                        ->where('merchandisers.campus_id', '=', $request->campus_id);
                })
                ->select('products.*')
//                ->where('campuses.id', $request->campus_id)
                ->where([['category_id', $category->id], ['payment_status', 'paid']])
                ->orWhere([['category_id', $category->id], ['payment_status', 'free']])
                ->latest()->paginate(15);
        }else{

            $products = Product::where([['category_id', $category->id], ['payment_status', 'paid']])
                ->orWhere([['category_id', $category->id], ['payment_status', 'free']])->with('image')->latest()->paginate(15);
        }

        return new ProductResource($products);
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
    public function index(Category $category, Request $request)
    {
        if($request->has('campus_id'))
        {
            $campus = Campus::find($request->campus_id);

            $users_campus_product = $campus->shopCampusProduct()->where([['category_id', $category->id], ['payment_status', 'paid']])
                ->orWhere([['category_id', $category->id], ['payment_status', 'free']]);

            $shops_campus_product = $campus->userCampusProduct->where([['category_id', $category->id], ['payment_status', 'paid']])
                ->orWhere([['category_id', $category->id], ['payment_status', 'free']]);

            $products = $users_campus_product->merge($shops_campus_product);

        }else {

            $products = Product::where([['category_id', $category->id], ['payment_status', 'paid']])
                ->orWhere([['category_id', $category->id], ['payment_status', 'free']])->with('image')->latest()->take(6)->get();

        }
        //        return new ProductResource(Product::where('category_id', $category->id)->latest()->take(6)->get());

        return new ProductResource($products);
    }


    public function saveCart(User $user, Request $request)
    {

       $cart = $request->validate(['cart' => 'nullable',]);

        $user->addToCart(json_encode($cart['cart']));

        return response()->json(['status' => 'cart saved']);
    }

    public function getCart()
    {
        $cart = auth()->user()->cart->where('status', 'in cart')->reverse()->first();

        return new CartResource($cart);
    }


    public function fetchShops(Request $request)
    {
        if($request->has('campus_id'))
        {
            return new AllShopsResource(Merchandiser::where([['payment_status', 'paid'], ['campus_id', $request->campus_id]])->paginate(8));
        }else{
            return new AllShopsResource(Merchandiser::where('payment_status', 'paid')->paginate(8));
        }

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



    public function campusShop(Campus $campus)
    {
        $shops = Merchandiser::where([['campus_id', $campus->id], ['payment_status' => 'paid']])->paginate(8);

        return new CampusShopsResource($shops);

    }


    public function campusProduct(Campus $campus)
    {

        $categories = Category::all();

        $finalProductList = collect();

        foreach ($categories as $category) {

            $cat_products = $category->product->reverse();

            if($cat_products)
            {
                $product_count = 1;

                $productList = collect();

                foreach ($cat_products as $product)
                {
                    if($product_count <= 4)
                    {
                        if($product->user)
                        {
                            if($product->user->campus_id == $campus->id){

                                $productList->add(new CategoryProductResource($product));

                                $product_count = $product_count + 1;
                            }

                        }else if($product->merchandiser){

                            if($product->merchandiser->campus_id == $campus->id){

                                $productList->add(new CategoryProductResource($product));

                                $product_count = $product_count + 1;
                            }

                        }
                    }

                }

                if($productList->count() > 0)
                {
                    $finalProductList->add([$category->category => $productList]);
                }

            }
        }

        return response()->json(['products' => $finalProductList]);

    }
}
