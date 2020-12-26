<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSellerRequest;
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

    public function payment(UserSellerRequest $request)
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
                    $user->sellersBillingDetail->update([
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

                $billing_details = $user->sellersBillingDetail;
            }

            $payment_details = array_merge($billing_details->toArray(), [
                'amount' => $paid_product->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
            ]);

            return $payment_details;

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {
                return response()->json(['message' => $payment_response]);

            } else {

                $user->addPayment([
                    'billing_detail_id' => $billing_details->id,
                    'amount' => $user->shopType->amount,
                    'email' => $request->email ?? $user->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phonenumber' => $request->phonenumber,
                    'txRef' => $payment_response['txref'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                ]);


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
