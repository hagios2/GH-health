<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Cart;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function callback()
    {
     
          
    }


    public function getKey($seckey){

      $hashedkey = md5($seckey);
      $hashedkeylast12 = substr($hashedkey, -12);

      $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
      $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

      $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
      return $encryptionkey;

    }



    public function encrypt3Des($data, $key)
    {
      $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
            return base64_encode($encData);
    }



    public function payviacard(PaymentRequest $request){ // set up a function to test card payment.

      $cart = Cart::find($request->cart_id);

      $payment_amount = $this->calculatePayment($cart);
      $user = auth()->guard('client')->user();

      if($user->company)
      {
        $email = $user->company->company_email;
        $client['client_company_id'] = $user->company->id;
      
      }else{

        $email = $user->email; 
        $client['client_id'] = $user->id;
      }

        error_reporting(E_ALL);
        ini_set('display_errors',1);
        
        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
        'cardno' => $request->cardno,
        'currency' => $request->currency,
        'country' => $request->country,
        'amount' => $payment_amount['grand_total'],
        "cvv"=> $request->cvv,
        "expirymonth"=> $request->expirymonth,
        "expiryyear"=> $request->expiryyear,
        'email' => $email,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'phonenumber' => $request->phonenumber,
        'IP' => $_SERVER['REMOTE_ADDR'],
        'txRef' => 'MC-' .now(),
      );
        
        $request = $this->initiateCard($data);
        
        if ($request) {

            $result = json_decode($request, true);

            if($result['status'] == 'success')
            {
                if(array_key_exists('suggested_auth', $result['data']))
                {
                  
                    if($result['data']['suggested_auth'] == 'NOAUTH_INTERNATIONAL' || $result['data']['suggested_auth'] == 'AVS_VBVSECURECODE')
                    {

                        $data['suggested_auth'] =  "NOAUTH_INTERNATIONAL";
                        $data['billingzip'] = "07205";
                        $data["billingcity"] = "Hillside";
                        $data['billingaddress'] = "470 Mundet PI";
                        $data['billingstate'] = "BA";
                        $data['billingcountry'] = "US";

                        $result = json_decode($this->initiateCard($data), true);

                    }else if($result['data']['suggested_autth'] == 'PIN')
                    {
                        return response()->json(['status' => 'payment requires pin']);
                    }
                }

                Transaction::create([
                  'invoice_id' => $cart->invoice->invoice_id,
                  key($client) => $client[key($client)],
                  'transaction_status' => $request['data']['status'],
                  'grand_total_amount' => $payment_amount['grand_total'],
                  'total_amount_without_charges' => $payment_amount[  'total_rollover_cost_amount'],
                  'currency' => $data['currency'],
                  'txref' => $data['txRef']
                ]);

                $cart->update(['payment_status' => 'paid']);

                return response()->json(['
                
                    status' => 'success', 
                    
                    'authurl' => $result['data']['authurl'],
                    
                    'chargeResponseMessage' => $result['data']['chargeResponseMessage'],
                  
                    'redirect_url' => route('callback')
                ]);
            }
            
        }else{

           return response()->json(['status' => 'Payment failed']);
        }
        

    }


    public function encryptKeys($data)
    {
        $SecKey = env('RAVE_SECRET_KEY');
          
        $key = $this->getKey($SecKey); 
        
        $dataReq = json_encode($data);
        
        $post_enc = $this->encrypt3Des( $dataReq, $key );

        $postdata = array(
          'PBFPubKey' => env('RAVE_PUBLIC_KEY'),
          'client' => $post_enc,
          'alg' => '3DES-24');

        return $postdata;
      
    }

    public function initiateCard($data)
    {
        $postdata = $this->encryptKeys($data);

        $ch = curl_init();
          
        curl_setopt($ch, CURLOPT_URL, "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/charge");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 

        $headers = array('Content-Type: application/json');
          
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $request = curl_exec($ch);

        curl_close($ch);
        
        return $request;
    }

    public function payviamobilemoneygh(Request $request){ // set up a function to test card payment.

      $cart = Cart::find($request->cart_id);

      $payment_amount = $this->calculatePayment($cart);
      $user = auth()->guard('client')->user();

      if($user->company)
      {
        $email = $user->company->company_email;
        $client['client_company_id'] = $user->company->id;
      
      }else{

        $email = $user->email; 
        $client['client_id'] = $user->id;
      }
        
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        
        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
        'currency' => 'GHS',
        'country' => 'GH',
        'payment_type' => 'mobilemoneygh',
        'amount' => $payment_amount['grand_total'],
        'phonenumber' => $request->phonenumber,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'network' => $request->network ?? 'mtn',
        'email' => $email,
        'IP' => $_SERVER['REMOTE_ADDR'],
        'txRef' => 'MC-' .now(),
        'orderRef' => 'MXX-'.now(),
        'is_mobile_money_gh' => 1,
        
      );

        $request = $this->initiateCard($data);

        $result = json_decode($request, true);

        Transaction::create([
          'invoice_id' => $cart->invoice->invoice_id,
          key($client) => $client[key($client)],
          'transaction_status' => $request['data']['status'],
          'grand_total_amount' => $payment_amount['grand_total'],
          'total_amount_without_charges' => $payment_amount[  'total_rollover_cost_amount'],
          'currency' => $data['currency'],
          'txRef' => $data['txRef'],
          'orderRef' => $data['orderRef'],
          'isMomoPayment' => true
        ]);

        $cart->update(['payment_status' => 'paid']);

        return response()->json([
          
            'status' => 'success', 
            
            'authurl' => $result['data']['link'],
            
            'payment_status' => $result['data']['status'],
          /* 
            'redirect_url' => route('callback') */
        ]);
  

    }


    public function verify($txref)
    {

        $result = array();

        $postdata =  array( 
          'txref' => $txref,
          'SECKEY' =>  env('RAVE_SECRET_KEY')
          );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
          'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);
        $err = curl_error($ch);

        if($err){
            // there was an error contacting rave
          die('Curl returned error: ' . $err);
        }


        curl_close ($ch);

        $result = json_decode($request, true);

        if('error' == $result->status){
          // there was an error from the API
          die('API returned error: ' . $result->message);
        }

        if('successful' == $result->data->status && '00' == $result->data->chargecode){
          // transaction was successful...
          // please check other things like whether you already gave value for this ref
          // If the amount and currency matches the expected amount and currency etc.
          // if the email matches the customer who owns the product etc
          // Give value
        }
    }


    public function calculatePayment(ScheduledAd $scheduledAd)
    {

        $subscriptions = $scheduledAd->subscription;
     
        $subscription_payable_amount_list = collect();
        
        $subscriptions->map(function($subscription) use
        ($subscription_payable_amount_list) {

          if($subscription->isAPrintSubscription)
          {
              
              $total_amount_without_rollover = $subscription->ratecard->cost;

              $total_amount_with_rollover = ($total_amount_without_rollover * (1 + $subscription->no_of_weeks));

          }else{

            $amountList = collect();

            $subscription->subscriptionDetail->map(function($subscription_detail) use ($amountList) {

                $amount = $subscription_detail->selected_spots*$subscription_detail->duration->rate;

                $amountList->push($amount);

            });

            $total_amount_without_rollover = $amountList->sum();

            $total_amount_with_rollover = ($total_amount_without_rollover * (1 + $subscription->no_of_weeks));

          }

          $subscription_payable_amount_list->push($total_amount_with_rollover
          );

        });

        return $total_rollover_cost_amount = $subscription_payable_amount_list->sum();

        // $payable_amount_with_tax = (1.125 * $total_rollover_cost_amount);

        // $grand_total = (1.05 * $payable_amount_with_tax); #payable_amount_with_tax_5percent


        // return [

        //   'grand_total' => $grand_total,

        //   'total_rollover_cost_amount' => $total_rollover_cost_amount #this is the amount
        // ];

    }


    public function storePaymentDetails()
    {

    }
}