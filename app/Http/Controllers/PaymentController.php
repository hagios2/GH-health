<?php

namespace App\Http\Controllers;

use App\PaidProduct;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Transaction;
use App\Cart;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:merchandiser')->except('callback');
    }

    public function callback(Request $request)
    {
        Log::info($request->all());

        $verified_payment = PaymentService::verifyPayment($request->txref);
    }

    public function payment(Request $request)
    {
        $user = auth()->guard('merchandiser')->user();

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

            $payment_details = array_merge((array)$billing_details, [
                'amount' => $user->shopType->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
            ]);

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {
                return response()->json(['message' => $payment_response]);

            } else {

                $user->addPayament([
                    'billing_detail_id' => $billing_details->id,
                    'amount' => $user->shopType->amount,
                    'email' => $request->email ?? $user->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phonenumber' => $request->phonenumber,

                ]);

                return response()->json($payment_response);
            }

        } else { #momo

            $payment_details = [
                'amount' => $user->shopType->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'vendor' => $request->vendor
            ];

            $payment_response = (new PaymentService)->payviamobilemoneygh($payment_details);
        }
    }

}

