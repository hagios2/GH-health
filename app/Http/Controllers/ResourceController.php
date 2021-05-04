<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Category;
use App\Helpers\CollectionHelper;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\RelatedProductResource;
use App\Product;
use App\ShopAd;
use App\ShopType;
use App\CarouselControl;
use Illuminate\Http\Request;
use App\Http\Resources\CampusResource;

class ResourceController extends Controller
{

    public function getCampus()
    {
        return CampusResource::collection(Campus::all('id', 'campus'));
    }


    public function getShopTypes()
    {
        return CampusResource::collection(ShopType::all('id', 'shop_type'));
    }

    public function getCourosleIamges(Campus $campus)
    {
       $carousel = CarouselControl::where('campus_id', $campus->id)->latest()->get();

       return $carousel;

       //return response()->json(['images', $carousel]);
    }

    public function newThisWeek(Request $request)
    {
        if($request->has('campus_id'))
        {
            $campus = Campus::find($request->campus_id);

            $users_campus_product = $campus->shopCampusProduct;

            $shops_campus_product = $campus->userCampusProduct;

            $products = $users_campus_product->merge($shops_campus_product);

        }else{

            $products = Product::where('payment_status', 'paid')
                ->orWhere('payment_status', 'free')->latest()->take(10)->get();
        }

        if($products->count() > 0 )
        {
            $products_list = collect();

            $products->map(function ($product) use ($products_list){

                if($product->image->count() > 0)
                {
                    $products_list->push($product);
                }
            });

            return RelatedProductResource::collection($products_list);
        }

        return RelatedProductResource::collection($products);
    }

    public function campusnewThisWeek(Campus $campus)
    {
        $categories = Category::all();

        $productList = collect();

        foreach ($categories as $category) {

            $cat_products = $category->product->reverse();

            if($cat_products)
            {
                $product_count = 0;

                foreach ($cat_products as $product)
                {
                    if($product_count <= 10)
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
            }
        }

        return $productList;

    }

    public function fetchAllAds()
    {
        $shop_ad = ShopAd::query()->latest()->get();

        return response()->json(['shop_ad' => $shop_ad]);
    }
}
