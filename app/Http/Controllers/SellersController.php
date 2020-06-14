<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Category;
use App\Product;

class SellersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api' OR 'auth:merchandiser']);
    }


    public function createCategory(Request $request)
    {
        Category::create($request->validate(['category' => 'required|string|unique:categories,category']));

        return response()->json(['status' => 'category created'], 200);
    }


    public function getCategories(Request $request)
    {
       
        return CategoryResource::collection(Category::all());

    }


    public function storeProduct(Category $category, ProductRequest $request)
    {
        
        $product = $request->all();

        if(auth()->guard('merchandiser')->user())
        {

            $product['merchandiser_id'] = auth()->guard('merchandiser')->id();

        }else{

            $product['user_id'] = auth()->guard('api')->id();

        }


        $product_id = $category->addProduct($product);

        return response()->json(['status' => 'success', 'product_id' => $product_id], 200);
    }


    public function updateProduct(Product $product, ProductRequest $request)
    {
       if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
       {
            return response()->json(['status' => 'Forbidden'], 403);

       }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){

            return response()->json(['status' => 'Forbidden'], 403);
       }

        $product->update($request->all());


        return response()->json(['status' => 'success'], 200);
    } 


    public function saveProductImages(Product $product, Request $request)
    {
       /*  if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
        {
             return response()->json(['status' => 'Forbidden'], 403);
 
        }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){
 
             return response()->json(['status' => 'Forbidden'], 403);
        }
 */
      
        if($request->hasFile('product_images'))
        {

            $files = $request->file('product_images');

            foreach($files as $file)
            {
    
                $fileName = now().'_'.$file->getClientOriginalName();
        
                $file->storeAs('public/product images/'.$product->id, $fileName);
        
                $product->addProductImage([
                    'path' => storage_path('app/public/product images/'.$product->id.'/'.$fileName)]);
        
            }
    
            return response()->json(['status' => 'files saved'], 200);
        }

        return response()->json(['status' => 'product images is required'], 422);
    }
    
}
