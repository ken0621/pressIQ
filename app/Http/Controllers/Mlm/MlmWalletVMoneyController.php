<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use App\Models\Tbl_voucher;
use App\Models\Tbl_membership_code_invoice;
use App\Models\Tbl_membership_code;
use Crypt;
use Redirect;
use DB;
use Request;
use View;
use App\Globals\abs\AbsMain;
use App\Models\Tbl_mlm_gc;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Request2;
use App\Models\Tbl_tour_wallet;
use App\Models\Tbl_vmoney_wallet_logs;
use App\Globals\Mlm_slot_log;
use Carbon\Carbon;
use App\Globals\Dragonpay2\RequestForm;
class MlmWalletVMoneyController extends Mlm
{
    public function index()
    {
        $data["_logs"] = DB::table("tbl_vmoney_wallet_logs")->where("customer_id", Self::$customer_id)->get();

        return view('mlm.vmoney.index', $data);
    }
    
    public function transfer()
    {
        $slot = DB::table("tbl_mlm_slot")->where("slot_id", Self::$slot_id)->first();

        if (isset($slot) && $slot) 
        {
            if (Request::input('vmoney_email')) 
            {
                if(Request::input('wallet_amount'))
                {
                    /* Set URL Sandbox or Live */
                    $url = "http://test.vmoney.com/gtcvbankmerchant/";
                    
                    /* API */
                    $post = 'mxtransfer.svc';
                    $environment = "sandbox";

                    if ($environment == "sandbox") 
                    {
                        $pass["apiKey"] = 'Vqzs90pKLb6iwsGQhnRS'; // Vendor API Key issued by VMoney
                        $pass["merchantId"] = 'M239658948226'; // Merchant ID registered within VMoney
                    }
                    else
                    {
                        $pass["apiKey"] = 'z9Gy1dBbnyj9cxMqXSKF'; // Vendor API Key issued by VMoney
                        $pass["merchantId"] = 'M132582139240'; // Merchant ID registered within VMoney
                    }

                    $pass["recipient"] = Request::input("vmoney_email"); // Recipient's email address
                    $pass["merchantRef"] = Self::$customer_id . time(); // Merchant reference number
                    $pass["amount"] = Request::input("wallet_amount"); // Amount of the transaction
                    $pass["currency"] = 'PHP'; // Currency being transferred (ie PHP)
                    $pass["message"] = 'Philtech VMoney Wallet Transfer'; // Memo or notes for transaction

                    $post_params = $url . $post . "?" . http_build_query($pass);

                    try 
                    {
                        $client = new Client();
                        $response = $client->post($post_params, $pass);
                        $stream = $response->getBody();
                        $contents = $stream->getContents(); // returns all the contents
                        $contents = $stream->getContents(); // empty string
                        $stream->rewind(); // Seek to the beginning
                        $contents = $stream->getContents(); // returns all the contents
                        $data_decoded = json_decode($contents);

                        /* Result */
                        if ($data_decoded->resultCode == "000") 
                        {   
                            $data_a['status'] = "success";
                            $logs["status"] = 1;

                            $arry_log['wallet_log_slot'] = $slot->slot_id;
                            $arry_log['shop_id'] = $slot->shop_id;
                            $arry_log['wallet_log_slot_sponsor'] = $slot->slot_id;
                            $arry_log['wallet_log_details'] = 'You have transfered ' . $pass["amount"] . ' To your E-wallet. ' . $pass["amount"] . ' is deducted to your wallet.';
                            $arry_log['wallet_log_amount'] = -($pass["amount"]);
                            $arry_log['wallet_log_plan'] = "V_MONEY";
                            $arry_log['wallet_log_status'] = "released";   
                            $arry_log['wallet_log_claimbale_on'] = Carbon::now();

                            Mlm_slot_log::slot_array($arry_log);
                        }
                        else
                        {
                            $data_a['status'] = "error";
                            $logs["status"] = 0;
                        }
                        
                        $data_a['message'] = $data_decoded->resultMsg;

                        $logs["vmoney_wallet_logs_date"] = Carbon::now();
                        $logs["vmoney_wallet_logs_email"] = Request::input("vmoney_email");
                        $logs["vmoney_wallet_logs_amount"] = Request::input("wallet_amount");
                        $logs["customer_id"] = Self::$customer_id;
                        $logs["txnId"] = $data_decoded->txnId;
                        $logs["merchantRef"] = $data_decoded->merchantRef;
                        Tbl_vmoney_wallet_logs::insert($logs);
                    } 
                    catch (\Exception $e) 
                    {
                        $data_a['status'] = "error";
                        $data_a['message'] = 'Caught exception: ' .  $e->getMessage();    
                    }
                }
                else
                {
                    $data_a['status'] = "error";
                    $data_a['message'] = "Wallet Amount is required";  
                }
            }
            else
            {
                $data_a['status'] = "error";
                $data_a['message'] = "Email Recipient is required";   
            }
        }
        else
        {
            $data_a['status'] = "error";
            $data_a['message'] = "No slot";   
        }
    
        return Redirect::to("/mlm/wallet/vmoney")->with($data_a["status"], $data_a["message"]);
    }
}