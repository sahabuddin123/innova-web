<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Util\BkashCredential;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\FeesTransections;
use Carbon\Carbon;
class BkashController extends Controller
{
    private $base_url;

    public function __construct()
    {
        // Sandbox Base URL
        //   $this->base_url = 'https://checkout.sandbox.bka.sh/v1.2.0-beta';

        // Live Base URL
        $this->base_url = 'https://checkout.pay.bka.sh/v1.2.0-beta'; 
    }

    public function authHeaders(){
        return array(
            'Content-Type:application/json',
            'Authorization:' .Session::get('bkash_token'),
            'X-APP-Key:' . config('services.bkash.app_key', env('BKASH_CHECKOUT_APP_KEY'))
        );
    }
         
    public function curlWithBody($url,$header,$method,$body_data_json){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function curlWithoutBody($url,$header,$method){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function storeLog($url,$header,$body_data,$response){
        $log_data=["url"=>$this->base_url.$url,"header"=>$header,"body"=> $body_data,"api response"=>json_decode($response)];
        return Log::channel('bkash')->info($log_data);
    }

    public function grant()
    {
        $header = array(
                'Content-Type:application/json',
                'username:' . config('services.bkash.user_name', env('BKASH_CHECKOUT_USER_NAME')),
                'password:' . config('services.bkash.password', env('BKASH_CHECKOUT_PASSWORD'))
                );
        $header_data_json=json_encode($header);

        $body_data = array(
            'app_key' => config('services.bkash.app_key', env('BKASH_CHECKOUT_APP_KEY')),
            'app_secret' => config('services.bkash.app_secret', env('BKASH_CHECKOUT_APP_SECRET'))
        );
        $body_data_json=json_encode($body_data);
        
        $response = $this->curlWithBody('/checkout/token/grant',$header,'POST',$body_data_json);


        $token = json_decode($response)->id_token;

        return $token;
    }

    public function pay(Request $request)
    {
        // $amount = 10000;
        // Session::put('payment_amount', $amount);

        // return view('Iframe.pay')->with([
        //     'amount' => $amount,
        // ]);
    }

    public function create(Request $request)
    {    
        // dd($request->all());
        // $data = $request->all();
        // $request = json_encode($data);
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();
        // print_r($data);
        $body_data = array(
            'amount' => Session::get('due_amount'),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv".Str::random(8)
        );
        $body_data_json=json_encode($body_data);
        // dd($body_data);
        $response = $this->curlWithBody('/checkout/payment/create',$header,'POST',$body_data_json);
        // dd($body_data_json);
        Session::put('paymentID', json_decode($response)->paymentID);
        // dd($response);
        return $response;
    }

    public function execute()
    {
        $paymentID = Session::get('paymentID');
        if (empty($paymentID)) {
            Session::put('errorMessage', 'No active payment session identifier found.');
            return response()->json(['errorMessage' => 'No active payment session identifier found.'], 400);
        }

        $header =$this->authHeaders();

        $response = $this->curlWithoutBody('/checkout/payment/execute/'.$paymentID,$header,'POST');
        
        $arr = json_decode($response,true);

        if(array_key_exists("errorCode",$arr) && $arr['errorCode'] != '0000'){
            Session::put('errorMessage', $arr['errorMessage']);
        }else if(array_key_exists("message",$arr)){
            // if execute api failed to response
            sleep(1);
            $response = $this->queryIframe($paymentID);
            $arr = json_decode($response, true);
        }
        
        Session::put('response',$response);
        Session::put('arr', $arr);
        // dd($arr);
        // $this->storeLog('/checkout/payment/execute/'.$paymentID,$header,$body_data = null,$response); // your database operation
        // if(array_key_exists("trxID",$arr) && $arr['trxID'] != null){
            //database inset
            // dd("Testing Datbase");
            // dd($arr);
            // $fees =  new FeesTransections;
            // $fees->student_id = Session::get('student_id');
            // $fees->paidamount = $arr['amount'];
            // $fees->paymentType = 1;
            // $fees->paiddate = Carbon::now()->format('Y-m-d');
            // $fees->paidremark = null;
            // $fees->channel = 2;
            // $fees->trxID = $arr['trxID'];
            // $fees->paymentID = $arr['paymentID'];
            // $fess->save();
        // }
        return $response;
    }

    public function queryIframe($paymentID){

        $header =$this->authHeaders();

        $response = $this->curlWithoutBody('/checkout/payment/query/'.$paymentID,$header,'GET');

        // $this->storeLog('/checkout/payment/query/'.$paymentID,$header,$body_data = null,$response); // your database operation

         return $response;
    }

    public function success(Request $request)
    {
        $arr = Session::get('arr');
        $studentId = Session::get('student_id');

        if (!$arr || !is_array($arr) || empty($arr['trxID']) || empty($arr['paymentID']) || empty($studentId)) {
            return redirect()->route('user.payment.history')
                ->with('error', 'No active payment session found.');
        }

        // Validate expected payment state: verify successful execution
        if (empty($arr['transactionStatus']) || strtolower($arr['transactionStatus']) !== 'completed') {
            return redirect()->route('user.payment.history')
                ->with('error', 'Payment transaction is not in a completed state.');
        }

        if (isset($arr['errorCode']) && $arr['errorCode'] !== '0000') {
            return redirect()->route('user.payment.history')
                ->with('error', 'Payment execution returned an error code.');
        }

        $trxId = $arr['trxID'];
        $lockKey = 'bkash_payment_trx_' . $trxId;
        $lock = Cache::lock($lockKey, 15);

        // Atomic deduplication: serialize concurrent requests for identical transaction ID
        $processPayment = function () use ($arr, $studentId, $trxId) {
            return DB::transaction(function () use ($arr, $studentId, $trxId) {
                $existing = FeesTransections::where('trxID', $trxId)->first();
                if ($existing) {
                    return $existing;
                }

                $fees = new FeesTransections;
                $fees->student_id = $studentId;
                $fees->paidamount = $arr['amount'] ?? 0;
                $fees->paymentType = Session::get('payment_type', 1);
                $fees->paiddate = Carbon::now()->format('Y-m-d');
                $fees->paidremark = "Pay by Bkash";
                $fees->channel = 2;
                $fees->status = 1;
                $fees->trxID = $trxId;
                $fees->paymentID = $arr['paymentID'] ?? null;

                try {
                    $fees->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    // Gracefully recover if database unique constraint catches a race condition
                    $existing = FeesTransections::where('trxID', $trxId)->first();
                    if ($existing) {
                        return $existing;
                    }
                    throw $e;
                }

                return $fees;
            });
        };

        if ($lock->get()) {
            try {
                $fees = $processPayment();
            } finally {
                $lock->release();
            }
        } else {
            // If lock could not be acquired immediately, wait briefly and check for existing record
            $fees = FeesTransections::where('trxID', $trxId)->first();
            if (!$fees) {
                // Secondary fallback attempt with lock wait
                try {
                    $fees = $lock->block(5, $processPayment);
                } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
                    $fees = FeesTransections::where('trxID', $trxId)->first();
                }
            }
        }

        if (!$fees) {
            return redirect()->route('user.payment.history')
                ->with('error', 'Payment transaction could not be verified or recorded.');
        }

        $responseOutput = Session::get('response');

        // Clear sensitive payment session keys to prevent replay attacks
        Session::forget(['paymentID', 'arr']);

        return view('users.profile.success')->with([
            'response' => $responseOutput
        ]);
    }
    
    public function fail(Request $request)
    {
        return view('users.profile.fail')->with([
            'errorMessage' => Session::get('errorMessage')
        ]);
    }
    

    public function search(Request $request){
        return view('users.profile.search-transaction');
    }

    public function searchTransaction(Request $request){
        $trxID = $request->trxID;

        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();

        $response = $this->curlWithoutBody('/checkout/payment/search/'.$trxID,$header,'GET');

        return view('users.profile.search-transaction')->with([
            'response' => $response,
        ]);
    }

    public function getRefund(Request $request)
    {
        return view('users.profile.refund');
    }

    public function refund(Request $request)
    {
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );
     
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/checkout/payment/refund',$header,'POST',$body_data_json);

        $arr = json_decode($response,true);
        
        $this->storeLog('/checkout/payment/refund',$header,$body_data,$response); // your database operation

        return view('users.profile.refund')->with([
            'response' => $response,
        ]);
    }

    public function getRefundStatus(Request $request)
    {
        return view('users.profile.Iframe.refund-status');
    }
    
    public function refundStatus(Request $request)
    {       
        $token = $this->grant();
        Session::put('bkash_token', $token);
        
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'trxID' => $request->trxID,
        );
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/checkout/payment/refund',$header,'POST',$body_data_json);

        return view('users.profile.Iframe.refund-status')->with([
            'response' => $response,
        ]);
    }

}

