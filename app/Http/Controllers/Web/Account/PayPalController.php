<?php
  
namespace App\Http\Controllers\Web\Account;
  
use App\Models\UserWalletmoney;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
   
class PayPalController extends AccountBaseController
{
    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(false);
    }

    public function pay(Request $request)
    {
        try {

            $response = $this->gateway->purchase(array(
                'amount' => ($request->amount*0.002),
                'currency' => "EUR",
                'returnUrl' => route('paypal_payment.success'),
                'cancelUrl' => route('paypal_payment.cancel')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            }
            else{
                return $response->getMessage();
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();
                
                $userId = auth()->check() ? auth()->user()->id : null;
            
                // Add Pending Record
                $name="";
                $obj = new UserWalletmoney;
                $obj->user_id = $userId;
                $obj->payment_method = "PayPal";
                $obj->amount = ($arr['transactions'][0]['amount']['total']) * 500;
                $obj->transaction_id = $arr['id'];
                $obj->receipt = $name;
                $obj->payment_status = 1;
                $obj->status = 1;
                $obj->save();
      
                $userWalletSave = new UserWallet;
                $userWalletSave->user_id= $userId;
                $userWalletSave->amount = ($arr['transactions'][0]['amount']['total']) * 500;
                $userWalletSave->save();

                return redirect(route('wallet_main_list'));
            }
            else{
                $arr = $response->getData();
                $userId = auth()->check() ? auth()->user()->id : null;
            
                // Add Pending Record
                $name="";
                $obj = new UserWalletmoney;
                $obj->user_id = $userId;
                $obj->payment_method = "PayPal";
                $obj->amount = ($arr['transactions'][0]['amount']['total']) * 500;
                $obj->receipt = $name;
                $obj->payment_status = 0;
                $obj->status = 0;
                $obj->save();
                
                return $response->getMessage();
            }
        }
        else{
            return 'Payment declined!!';
        }
    }

    public function error()
    {
        return 'User declined the payment!';   
    }
}

?>