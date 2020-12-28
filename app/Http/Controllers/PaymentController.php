<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchandiserPaymentRequest;
use App\MerchandiserPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
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

        $response= json_decode($request->response, true);

        $txref = $response['txRef'];

        $verified_payment = PaymentService::verifyPayment($txref);

        Log::info('logging Verified Merchandiser Payemnt | '. $verified_payment);

        $payment = MerchandiserPayment::where('txRef',  $txref)->first();

        Log::info('logging Merchandiser Payment response | '. $payment);

        if('successful' == $verified_payment){

            $payment->update(['status' => 'success']);

            $shop = $payment->shop;

            $shop->update(['payment_status' => 'paid']);

        }else{
            $payment->update(['status' => 'failed']);
        }
    }

    public function payment(MerchandiserPaymentRequest $request)
    {
        $shop = auth()->guard('merchandiser')->user();

        if ($request->payment_method === 'card_payment') {

            $billing_details = $shop->addSellersBillingDetail([
                'cardno' => $request->cardno,
                'expirymonth' => $request->expirymonth,
                'expiryyear' => $request->expiryyear,
                'cvv' => $request->cvv,
                'billingzip' => $request->billingzip,
                'billingcity' => $request->billingcity,
                'billingaddress' => $request->billingaddress,
                'billingstate' => $request->billingstate,
                'billingcountry' => $request->billingcountry ?? 'GH'
            ]);

            $payment_details = array_merge($billing_details->toArray(), [
                'amount' => $shop->shopType->amount,
                'email' => $request->email ?? $shop->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'callback' => route('shop.payment.callback'),
            ]);

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {

                Log::error($payment_response);

                return response()->json(['message' => 'Payment process failed']);

            } else {

                Log::info($payment_response);

                MerchandiserPayment::create([
                    'billing_detail_id' => $billing_details->id,
                    'amount' => $shop->shopType->amount,
                    'email' => $request->email ?? $shop->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phonenumber' => '233'. substr($request->phonenumber, -9),
                    'txRef' => $payment_response['txref'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                ]);

                return response()->json($payment_response);
            }

        } else { #momo

            $payment_details = [
                'amount' => $shop->shopType->amount,
                'email' => $request->email ?? $shop->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'vendor' => $request->vendor
            ];

            $payment_response = (new PaymentService)->payviamobilemoneygh($payment_details);
        }
    }

}

