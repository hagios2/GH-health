<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function addCarouselImage(Request $request)
    {
        $files = $request->file('product_images');

        foreach($files as $file)
        {

            $fileName = now().'_'.$file->getClientOriginalName();
    
            $file->storeAs('public/carousel images/'.$product->id, $fileName);
    
            $product->addProductImage([
                'path' => storage_path('app/public/product images/'.$product->id.'/'.$fileName)]);
    
        }

        return response()->json(['status' => 'files saved'], 200);
    }

    // public function dd

}
