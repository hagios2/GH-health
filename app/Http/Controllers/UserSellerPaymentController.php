<?php

namespace App\Http\Controllers;

use App\PaidProduct;
use App\Product;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSellerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('callback');
    }


    public function payingProduct(Request $request)
    {
        $product = Product::find($request->product_id);

        $price = (double) $product->price;

        if($price >= 0.10 && $price <= 20.00)
        {
            $product->update(['payment_status' => 'free']);

            return response()->json(['message' => 'free product']);

        }elseif($price >= 20.10 && $price <= 1000.00) {

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 0.01 * $price]);

        }elseif($price >= 1000.01 && $price <= 3000.00) {

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 12.00]);

        }elseif($price >= 3000.01){

            $product->update(['payment_status' => 'requires payment']);

            $product->addPaidProduct(['amount' => 15.00]);
        }

        return response()->json(['message' => 'free product']);
    }


    public function payment(Request $request)
    {
        $user = auth()->guard('api')->user();

        $paid_product = PaidProduct::where('product_id', $request->product_id)->first();

        if ($request->payment_method === 'card_payment') {
            if (!$user->sellersBillingDetail) {
                $billing_details = $user->addSellersBillingDetail([
                    'cardno' => $request->cardno,
                    'expirymonth' => $request->expirymonth,
                    'expiryyear' => $request->expiryyear,
                    'cvv' => $request->cvv,
                    'billingzip' => $request->billingzip,
                    'billingcity' => $request->billingcity,
                    'billingaddress' => $request->billingaddress,
                    'billingstate' => $request->billingstate,
                    'billingcountry' => $request->billingcountry ?? 'Ghana'
                ]);
            } else {

                $billing_details = $user->sellersBillingDetail;
            }

            $billing_details = (array)$billing_details;

            $payment_details = array_merge($billing_details, [
                'amount' => $paid_product->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
            ]);

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {
                return response()->json(['message' => $payment_response]);

            } else {

                return response()->json($payment_response);
            }

        } else { #momo

            $payment_details = [
                'amount' => $paid_product->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'vendor' => $request->vendor
            ];

            $payment_response = (new PaymentService)->payviamobilemoneygh($payment_details);

            return $payment_response;
        }
    }


    public function callback(Request $request)
    {
        Log::info($request->all());

        $verified_payment = PaymentService::verifyPayment($request->txref);
    }

}
