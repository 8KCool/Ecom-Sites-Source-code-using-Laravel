<?php

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Http\Request;
use App\Helpers\Date;
use App\Models\UserWalletmoney;
use App\Models\UserWallet;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class WalletController extends PanelController
{
    //
    public function index()
    {
       $data= [];	
	   return appView('wallet.walletlist', $data);
    }

    public function ajax_walletlist(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input("start");
        $rowperpage = $request->input("length");
        $columnIndex_arr = $request->input('order');
        $columnName_arr = $request->input('columns');
        $order_arr = $request->input('order');
        $search_arr = $request->input('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $OrderbyArr=array(0=>'user_walletmoneys.id', 1=>'users.name', 2=>'user_walletmoneys.payment_method', 3=>'user_walletmoneys.amount', 4=>'user_walletmoneys.receipt', 5=>'user_walletmoneys.created_at', 6=>'user_walletmoneys.status');
        $orderby= $OrderbyArr[$columnName];
        // Total records
        $totalRecords = DB::table('user_walletmoneys')
                        ->select(DB::raw('count(*) as allcount'))
                        ->get();        

        $totalRecordswithFilter = DB::table('user_walletmoneys')
                                ->select(DB::raw('count(*) as allcount'))
                                ->leftJoin('users', 'users.id', '=', 'user_walletmoneys.user_id')
                                ->where(function ($q) use ($searchValue) {
                                    return $q->where('users.name', 'like', '%' . $searchValue . '%')
                                            ->orWhere('user_walletmoneys.payment_method', 'like', '%' . $searchValue . '%')
                                            ->orWhere('user_walletmoneys.status', 'like', '%' . $searchValue . '%')
                                            ->orWhere('user_walletmoneys.created_at', 'like', '%' . $searchValue . '%'); 
                                 })
                                ->get();

        // Get records, also we have included search filter as well
        //DB::enableQueryLog();
        $records =  DB::table('user_walletmoneys')
                    ->select('user_walletmoneys.*', 'users.name', 'users.email')
                    ->leftJoin('users', 'users.id', '=', 'user_walletmoneys.user_id')
                    ->where(function ($q) use ($searchValue) {
                        return $q->where('users.name', 'like', '%' . $searchValue . '%')
                                ->orWhere('user_walletmoneys.payment_method', 'like', '%' . $searchValue . '%')
                                ->orWhere('user_walletmoneys.status', 'like', '%' . $searchValue . '%')
                                ->orWhere('user_walletmoneys.created_at', 'like', '%' . $searchValue . '%'); 
                    })                  
                    ->skip($start)
                    ->take($rowperpage)
                    ->orderBy($orderby, $columnSortOrder)
                    ->get();
        /*$query = DB::getQueryLog();
        dd($query);*/
        
        $data_arr = array();
        $slno=1;
        foreach ($records as $record) {
            $walletDocId= $record->id;
            
            if($record->status==1){
                $status='<div id="status_id_'.$walletDocId.'"><span class="badge badge-info">Approved</span></div>';
                $statusDropdown= '';
            } elseif($record->status==2){
                $status='<div id="status_id_'.$walletDocId.'"><span class="badge badge-danger">Reject</span></div>';
                $statusDropdown= '<select name="changestatus" class="form-control onchange_status" data-attr="'.$walletDocId.'" data-userid="'.$record->user_id.'">
                            <option value="0">Pending</option>
                            <option value="2" selected>Reject</option>
                            <option value="1">Approved</option>
                            </select>';
            } else {
                $status='<div id="status_id_'.$walletDocId.'"><span class="badge badge-warning">Pending</span></div>';
                $statusDropdown= '<select name="changestatus" class="form-control onchange_status" data-attr="'.$walletDocId.'" data-userid="'.$record->user_id.'">
                            <option value="0" selected>Pending</option>
                            <option value="2">Reject</option>
                            <option value="1">Approved</option>
                            </select>';
            }
            $receipturl = url('/public/images/receipt/'.$record->receipt);
            $receipt = '<a href="'.$receipturl.'" target="_blank">View</a>';

            $data_arr[] = array(
                $slno,
                $record->name,
                $record->payment_method,
                $record->amount,
                $receipt,
                $record->created_at,
                $status,                
                $statusDropdown,
            );
            $slno++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords[0]->allcount,
            "iTotalDisplayRecords" => $totalRecordswithFilter[0]->allcount,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function ajax_wallet_statusupdate(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $userid = $request->input('userid');
        if($id > 0){
            $UserWalletmoney = UserWalletmoney::find($id);
            $UserWalletmoney->status = $status;
            $UserWalletmoney->save();

            if($status==1){
                $userWallet = UserWallet::where('user_id',$userid)->first();
                $userWalletmoneyDetail = UserWalletmoney::where('id',$id)->first();                
                if(!empty($userWallet)){
                    $newAmount= $userWalletmoneyDetail->amount + $userWallet->amount;
                    $userWalletSave = UserWallet::find($userWallet->id);
                    $userWalletSave->amount = $newAmount;
                    $userWalletSave->save();
                } else {
                    $newAmount= $userWalletmoneyDetail->amount;                    
                    $userWalletSave = new UserWallet;
                    $userWalletSave->user_id= $userid;
                    $userWalletSave->amount = $newAmount;
                    $userWalletSave->save();
                }
                
            }
            echo "success";
            exit;
        }        
    }
    
    public function emis(Request $request)
    {
        print_r($request);
        print_r($_REQUEST);
        exit;
        #new payment api work

        $amount=$request->input('amount');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://pagamentonline.emis.co.ao/online-payment-gateway/portal/frameToken',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "reference": "87987222342",
        "amount": "'.$amount.'",
        "token": "83a12af5-2bdf-4df3-abfa-ae3351b2cef6",
        "mobile": "PAYMENT",
        "card":"DISABLED",
        "cssUrl": "",
        "callbackUrl": "https://webhook.site/00059834-3224-4b6e-80bd-70f613354ceb"

        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        $response=json_decode($curl);
        
        if(empty($response)){
            $data=[
                'status'=>'error'
            ];
            echo json_encode($data);
            exit;
        }
        
        $url='https://pagamentonline.emis.co.ao/online-payment-gateway/portal/frame?token='.$response['id'];
        $data=[
            'status'=>'success',
            'url'=>$url,
        ];
        echo json_encode($data);
        exit;
    }
}
