<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class UserSellerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function payingProduct(Request $request)
    {
        $product = Product::find($request->product_id);

//        if($product->)
//        {
//
//        }

    }
}
