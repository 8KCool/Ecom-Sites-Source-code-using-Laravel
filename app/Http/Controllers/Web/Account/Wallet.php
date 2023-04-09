<?php

namespace App\Http\Controllers\Web\Account;
use App\Helpers\Date;
use App\Models\UserWalletmoney;
use App\Models\UserWallet;
use Illuminate\Http\Request as HttpRequest;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use File;
use Validator;
date_default_timezone_set("Africa/Luanda");
class Wallet extends AccountBaseController
{
    //
    private $perPage = 10;
    public function __construct()
	{
		parent::__construct();
		
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
	}

    public function index()
	{
		$data= [];	
        $userId = auth()->check() ? auth()->user()->id : null;
        $data['uploadswallets'] = UserWalletmoney::where('user_id', '=', $userId)->orderBy('created_at', 'desc')->paginate($this->perPage);
        
        MetaTag::set('title', t('wallet_text'));
		MetaTag::set('description', t('wallet_desc', ['appName' => config('settings.app.app_name')]));
		return appView('account.wallet', $data);
	}
	
	/**
	 * Call Init Appypay Request 
	 */
	public function appypayInit(HttpRequest $request)
	{
        // Request Params
        $phone = $request->phone;
        $amount = $request->amount;
        $userId = auth()->check() ? auth()->user()->id : null;
        $userName = auth()->check() ? auth()->user()->name : null;
        $merchantTransactionId = time();
        
        // Add Pending Record
        $name="";
        $obj = new UserWalletmoney;
        $obj->user_id = $userId;
        $obj->payment_method = "appypay";
        $obj->amount = $amount;
        $obj->receipt = $name;
        $obj->transaction_id = $merchantTransactionId;
        $obj->payment_status = 0;
        $obj->status = 0;
        $obj->save();
        
        return response()->json([
            "result" => 'pending',
            'phone' => $phone,
            'merchantTransactionId' => $merchantTransactionId,
        ]);
	}
	
	/**
	 * Finish Appypay Request
	 */
	public function appypayFinish(HttpRequest $request)
	{
        // Request Params
        $merchantTransactionId = $request->merchantTransactionId;
        $phone = $request->phone;
        $prevWallet = UserWalletmoney::where(array('payment_method'=>'appypay','transaction_id'=>$merchantTransactionId))->first();
        $amount = $prevWallet->amount;
        $userId = auth()->check() ? auth()->user()->id : null;
        $userName = auth()->check() ? auth()->user()->name : null;
        
        // API Params
        $clientId = "2c2d4b7f-d132-467d-a6c9-6d64d27139d8";
        $clientSecret = "q0W8Q~-QBYZux9Q4uCD4nVEBrnIebUi9yJeujdw7";
        $gpoPamentMethod = "GPO_3ecfb080-517c-4a38-aa48-6ef9e8a96219";
        $validDate = "03/2025";
        $resource = "bee57785-7a19-4f1c-9c8d-aa03f2f0e333";
               
        // Get API Token     
        $tokenUrl = 'https://login.microsoftonline.com/appypay.co.ao/oauth2/token';   
        $tokenParams = [
            "grant_type" => "client_credentials",
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "resource" => $resource
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $tokenUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HEADER => true, 
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HEADERFUNCTION=> array($this,'handleHeaderLine'),
          CURLOPT_POSTFIELDS => http_build_query($tokenParams),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        $pieces = explode("{", $response);
        $resp = "{" . $pieces[1];
        $res = json_decode($resp);
        if ($res != NULL && $res->token_type != NULL) {
            $token = $res->token_type . " " . $res->access_token;
            
            // Call [Post a charge.] API
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.appypay.co.ao/v1.2/charges",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 90,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"capture\": true,\n  \"amount\": " . $amount . ",\n  \"orderOrigin\": 0,\n  \"paymentMethod\": \"GPO_3ecfb080-517c-4a38-aa48-6ef9e8a96219\",\n  \"description\": \"POSTMAN\",\n  \"merchantTransactionId\": \"" . $merchantTransactionId . "\",\n  \"paymentInfo\": {\n    \"phoneNumber\": \"" . $phone . "\"\n  },\n  \"options\": {\n    \"Option1\": \"string\",\n    \"Option2\": \"string\"\n  },\n \"callback_url\": \"https://oprivado.com/wallet/appypay_webhook\"}",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Accept-Language: en",
                    "Authorization: " . $token,
                    "Content-Type: application/json"
                ],
            ]);
            
            $response = curl_exec($curl);
            curl_close($curl);
            
            $resp = json_decode($response);
            if ($resp != NULL) {
                if ($resp->responseStatus->successful) {
                    $userTransactionWallet = UserWalletmoney::where(array('payment_method'=>'appypay','transaction_id'=>$merchantTransactionId))->first();
                    $userTransactionWallet->payment_status = 1;
                    $userTransactionWallet->status = 1;
                    $userTransactionWallet->save();
                    
                    $userAmount = 0;
                    if(!empty($userTransactionWallet)) {
                        $userWallet = UserWallet::where('user_id',$userId)->first();
                        if(!empty($userWallet)){
                            $newAmount= $userTransactionWallet->amount + $userWallet->amount;
                            $userWalletSave = UserWallet::find($userWallet->id);
                            $userWalletSave->amount = $newAmount;
                            $userWalletSave->save();
                            $userAmount = $newAmount;
                        } else {
                            $newAmount= $userTransactionWallet->amount;                    
                            $userWalletSave = new UserWallet;
                            $userWalletSave->user_id= $userid;
                            $userWalletSave->amount = $newAmount;
                            $userWalletSave->save();
                            $userAmount = $newAmount;
                        }
                    }
					
                    return response()->json([
                        "result" => 'success',
                        "prevWalletId" => $prevWallet->id,
                        'amount' => $userName . '(' . $userAmount . ') KZ'
                    ]);
                } else if ($resp->responseStatus->message == "CODE_-1")
                    $error = "Missing phone number.";
                else
                    $error = $resp->responseStatus->message;
            } else
                $error = "You should confirm within 90s.";
        } 
        else
            $error = "We can not get any token with your phone number.";
        
        return response()->json([
            "result" => 'failed',
            "error" => $error
        ]);
	}

    /**
     * Call Appypay API and Create transaction.
     */
    public function appypay(HttpRequest $request)
    {
        $error = "";
        
        // Request Params
        $phone = $request->phone;
        $amount = $request->amount;
        $userId = auth()->check() ? auth()->user()->id : null;
        $userName = auth()->check() ? auth()->user()->name : null;
        $merchantTransactionId = time();
        
        // Add Pending Record
        $name="";
        $obj = new UserWalletmoney;
        $obj->user_id = $userId;
        $obj->payment_method = "appypay";
        $obj->amount = $amount;
        $obj->receipt = $name;
        $obj->transaction_id = $merchantTransactionId;
        $obj->payment_status = 0;
        $obj->status = 0;
        $obj->save();
        
        // API Params
        $clientId = "2c2d4b7f-d132-467d-a6c9-6d64d27139d8";
        $clientSecret = "q0W8Q~-QBYZux9Q4uCD4nVEBrnIebUi9yJeujdw7";
        $gpoPamentMethod = "GPO_3ecfb080-517c-4a38-aa48-6ef9e8a96219";
        $validDate = "03/2025";
        $resource = "bee57785-7a19-4f1c-9c8d-aa03f2f0e333";
               
        // Get API Token     
        $tokenUrl = 'https://login.microsoftonline.com/appypay.co.ao/oauth2/token';   
        $tokenParams = [
            "grant_type" => "client_credentials",
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "resource" => $resource
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $tokenUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HEADER => true, 
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HEADERFUNCTION=> array($this,'handleHeaderLine'),
          CURLOPT_POSTFIELDS => http_build_query($tokenParams),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        $pieces = explode("{", $response);
        $resp = "{" . $pieces[1];
        $res = json_decode($resp);
        if ($res != NULL && $res->token_type != NULL) {
            $token = $res->token_type . " " . $res->access_token;
            
            // Call [Post a charge.] API
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.appypay.co.ao/v1.2/charges",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 90,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"capture\": true,\n  \"amount\": " . $amount . ",\n  \"orderOrigin\": 0,\n  \"paymentMethod\": \"GPO_3ecfb080-517c-4a38-aa48-6ef9e8a96219\",\n  \"description\": \"POSTMAN\",\n  \"merchantTransactionId\": \"" . $merchantTransactionId . "\",\n  \"paymentInfo\": {\n    \"phoneNumber\": \"" . $phone . "\"\n  },\n  \"options\": {\n    \"Option1\": \"string\",\n    \"Option2\": \"string\"\n  },\n \"callback_url\": \"https://oprivado.com/wallet/appypay_webhook\"}",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Accept-Language: en",
                    "Authorization: " . $token,
                    "Content-Type: application/json"
                ],
            ]);
            
            $response = curl_exec($curl);
            curl_close($curl);
            
            $resp = json_decode($response);
            if ($resp != NULL) {
                if ($resp->responseStatus->successful) {
                    $userTransactionWallet = UserWalletmoney::where(array('payment_method'=>'appypay','transaction_id'=>$merchantTransactionId))->first();
                    $userTransactionWallet->payment_status = 1;
                    $userTransactionWallet->status = 1;
                    $userTransactionWallet->save();
                    
                    $userAmount = 0;
                    if(!empty($userTransactionWallet)) {
                        $userWallet = UserWallet::where('user_id',$userId)->first();
                        if(!empty($userWallet)){
                            $newAmount= $userTransactionWallet->amount + $userWallet->amount;
                            $userWalletSave = UserWallet::find($userWallet->id);
                            $userWalletSave->amount = $newAmount;
                            $userWalletSave->save();
                            $userAmount = $newAmount;
                        } else {
                            $newAmount= $userTransactionWallet->amount;                    
                            $userWalletSave = new UserWallet;
                            $userWalletSave->user_id= $userid;
                            $userWalletSave->amount = $newAmount;
                            $userWalletSave->save();
                            $userAmount = $newAmount;
                        }
                    }
					
                    return response()->json([
                        "result" => 'success',
                        'amount' => $userName . '(' . $userAmount . ') KZ'
                    ]);
                } else if ($resp->responseStatus->message == "CODE_-1")
                    $error = "Missing phone number.";
                else
                    $error = $resp->responseStatus->message;
            } else
                $error = "You should confirm within 90s.";
        } 
        else
            $error = "We can not get any token with your phone number.";
        
        return response()->json([
            "result" => 'failed',
            "error" => $error
        ]);
    }

    public function recharge()
    {
		$data= [];	
        $userId = auth()->check() ? auth()->user()->id : null;
        $data['uploadswallets'] = UserWalletmoney::where('user_id', '=', $userId)->orderBy('created_at', 'desc')->paginate($this->perPage);
		$data['randNum'] = rand();
        
        MetaTag::set('title', t('Wallet'));
		MetaTag::set('description', t('Wallet on', ['appName' => config('settings.app.app_name')]));
		return appView('account.wallet-recharge', $data);
    }

    public function uploadPaymentDocument(HttpRequest $request){
        $data= [];
        //print_r($request->post());
        //exit;
        $payment_method = $request->input('payment_method');
        $validationArray= [
          'payment_method' => 'required',
          'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ];

        if($payment_method!="vpos"){
            $validationArray['telephone']= '';
            $validationArray['hiddenkzprice']= 'required';
        }

        $this->validate($request, $validationArray);
        $payment_method = $request->input('payment_method');
        $amount = $request->input('amount');   
        $hiddenkzprice = $request->input('hiddenkzprice');
        $telephone = $request->input('telephone');

        $transactionID="";
        $paymentStatus= 0;
        if($payment_method=="vpos"){
            $pos_id= env('VPOS_POS_ID');
            $idempotency_key= env('VPOS_IDEMPOTENCY_KEY');
            $bearer_token= env('VPOS_TOKEN');

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://vpos.ao/api/v1/transactions',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HEADER => true, 
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_HEADERFUNCTION=> array($this,'handleHeaderLine'),
              CURLOPT_POSTFIELDS =>'{"type": "payment", "pos_id": '.$pos_id.', "mobile": "'.$telephone.'", "amount": "'.$amount.'", "callback_url": "https://paiaki.com/wallet/vpos_webhook"}',
              CURLOPT_HTTPHEADER => array(
                //'Idempotency-Key: '.$idempotency_key,
                'Authorization: Bearer '.$bearer_token,
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseDetail= $this->http_parse_headers($response);
            //exit;
            if(!empty($responseDetail['location'])){
                $explodeLocation= explode("/",$responseDetail['location']);
                $transactionID= trim($explodeLocation[4]);

                $curl2 = curl_init();
                curl_setopt_array($curl2, array(
                  CURLOPT_URL => 'https://vpos.ao/'.$responseDetail['location'],
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$bearer_token
                  ),
                ));

                $response2 = curl_exec($curl2);
                curl_close($curl2);
                if(!empty($response2)){
                    $jsonDecodeResponse2= json_decode($response2);
                    if(!empty($jsonDecodeResponse2->id) && !empty($jsonDecodeResponse2->status)){
                       //$transactionID= $jsonDecodeResponse2->id; 
                       if($jsonDecodeResponse2->status=="accepted"){
                          $paymentStatus= 1;
                       } else {
                          $paymentStatus= 0;
                       }                       
                    }                 
                }
            }      
        }
        //exit;

        $userId = auth()->check() ? auth()->user()->id : null;
        $name="";
        if($request->hasfile('receipt')) {
            $receipt= $request->file('receipt');
            $name = (int)(microtime(true) * 1000000000).date('Ymd')."_".$receipt->getClientOriginalName();
            $receipt->move(public_path().'/images/receipt/', $name);
        }
        $obj = new UserWalletmoney;
        $obj->user_id = $userId;
        $obj->payment_method = $payment_method;
        $obj->amount = $amount;
        $obj->receipt = $name;
        $obj->transaction_id = $transactionID;
        $obj->payment_status = $paymentStatus;
        $obj->status = 0;
        $obj->save();

        $request->session()->flash('success_message', 'Successfully saved!');
        return redirect()->back();
    }

    public function ajax_checkwallet_balance(HttpRequest $request)
    {  
        $packagePrice= $request->input("packagePrice");
        if(!empty($packagePrice)){
            $userId = auth()->check() ? auth()->user()->id : null;
            $userWallet = UserWallet::where('user_id',$userId)->first();
            if(!empty($userWallet)){
                if($packagePrice<=$userWallet->amount){
                  $return= array("status"=>"success"); 
                  echo json_encode($return);
                  exit; 
                } else {
                  $return= array("status"=>"error","message"=>"Não tem saldo suficiente na sua carteira. Carregue a sua conta!"); 
                  echo json_encode($return);
                  exit; 
                }
            } else {

                $return= array("status"=>"error","message"=>"Não tem saldo suficiente na sua carteira. Carregue a sua conta!");
                echo json_encode($return);
                exit; 
            }
        }        
    }

    public function handleHeaderLine( $curl, $header_line ) {
      return strlen($header_line);
    }

    public function http_parse_headers($raw_headers)
    {
        $headers = array();
        $key = ''; // [+]

        foreach(explode("\n", $raw_headers) as $i => $h)
        {
            $h = explode(':', $h, 2);

            if (isset($h[1]))
            {
                if (!isset($headers[$h[0]]))
                    $headers[$h[0]] = trim($h[1]);
                elseif (is_array($headers[$h[0]]))
                {
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1]))); // [+]
                }
                else
                {
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [+]
                }

                $key = $h[0]; // [+]
            }
            else // [+]
            { // [+]
                if (substr($h[0], 0, 1) == "\t") // [+]
                    $headers[$key] .= "\r\n\t".trim($h[0]); // [+]
                elseif (!$key) // [+]
                    $headers[0] = trim($h[0]);trim($h[0]); // [+]
            } // [+]
        }

        return $headers;
    }

    public function vpos_webhook(HttpRequest $request)
    {
        $request= $request->all();
        print_r($request);
        if(!empty($request)){
            $transactionID= $request['id'];
            $userTransactionWallet = UserWalletmoney::where(array('payment_method'=>'vpos','transaction_id'=>$transactionID))->first();
            if($request["status"]=="accepted"){                
                if(!empty($userTransactionWallet)){
                    $userid= $userTransactionWallet->user_id;
                    $userWallet = UserWallet::where('user_id',$userid)->first();
                    if(!empty($userWallet)){
                        $newAmount= $userTransactionWallet->amount + $userWallet->amount;
                        $userWalletSave = UserWallet::find($userWallet->id);
                        $userWalletSave->amount = $newAmount;
                        $userWalletSave->save();
                    } else {
                        $newAmount= $userTransactionWallet->amount;                    
                        $userWalletSave = new UserWallet;
                        $userWalletSave->user_id= $userid;
                        $userWalletSave->amount = $newAmount;
                        $userWalletSave->save();
                    }
                    $userWalletStatusSave = UserWalletmoney::find($userTransactionWallet->id);
                    $userWalletStatusSave->payment_status = 1;
                    $userWalletStatusSave->status = 1;
                    $userWalletStatusSave->save();
                }
            } else {
                if(!empty($userTransactionWallet)){
                    $userWalletStatusSave = UserWalletmoney::find($userTransactionWallet->id);
                    $userWalletStatusSave->payment_status = 0;
                    $userWalletStatusSave->status = 0;
                    $userWalletStatusSave->save();
                }
            }
        }
    }

    /*public function update_userwallet()
    {

        $result= DB::table('users')
                ->select('users.id')
                ->whereNotExists(function ($query) {
                   $query->select(DB::raw(1))
                         ->from('user_wallets')
                         ->whereColumn('user_wallets.user_id', 'users.id');
               })
               ->get();

        if(!empty($result)){
            foreach($result as $val){
                $userid= $val->id;
                $userWallet = UserWallet::where('user_id',$userid)->first();
                if(empty($userWallet)){
                    UserWallet::create(['user_id'=>$userid,'amount'=>0.00]);
                }
            }
        }
    }*/
}
