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
        $data = [];
        return view('mlm.vmoney.index', $data);
    }
    
    public function transfer()
    {
        /* Set URL Sandbox or Live */
        $url = "http://test.vmoney.com/gtcvbankmerchant/";
        
        /* API */
        $post = 'mxtransfer.svc';
        
        $pass["apiKey"] = 'z9Gy1dBbnyj9cxMqXSKF'; // Vendor API Key issued by VMoney
        $pass["merchantId"] = 'M132582139240'; // Merchant ID registered within VMoney
        $pass["recipient"] = Request::input("vmoney_email"); // Recipient's email address
        $pass["merchantRef"] = 1; // Merchant reference number
        $pass["amount"] = Request::input("wallet_amount"); // Amount of the transaction
        $pass["currency"] = 'PHP'; // Currency being transferred (ie PHP)
        $pass["message"] = 'Philtech VMoney Wallet Transfer'; // Memo or notes for transaction
        /* ----------------------------------------------------------- */
        // dd($pass);
        $params['form_params'] = $pass;
        $params['body'] = json_encode($pass);
        
        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'form-data', 
                    'Credentials' => '',
                    'contents' => '',
                    'name' => ''];
        
        $headers = ['multipart' => ['headers' => $headers], 'headers' => $headers];    

        $client_info['base_uri'] = $url . $post;
        $client_info['timeout'] = 10.0;
        $client = new Client($client_info, $headers);

        try 
        {
            $uri = $url . $post;
            $request = new Request2('POST', $uri, $params);
            $response = $client->send($request, $headers);
            $body = $response->getBody();
            $data = $body->read(1024);
            $data_decoded = json_decode($data);
            if ($data_decoded->resultCode == "000") 
            {
                /* Insert Logs */
                $logs["vmoney_wallet_logs_date"] = Carbon::now();
                $logs["vmoney_wallet_logs_email"] = Request::input("vmoney_email");
                $logs["vmoney_wallet_logs_amount"] = Request::input("wallet_amount");
                $logs["shop_id"] = Self::$shop_id;
                Tbl_vmoney_wallet_logs::insert($logs);
                
                $data_a['status'] = "success";
            }
            else
            {
                $data_a['status'] = "error";
            }
            
            $data_a['message'] = $data_decoded->resultMsg;
            if(isset($data_decoded->result))
            {
            	$data_a['result'] = $data_decoded->result;
            }
        }
        catch (\Exception $e) 
        {
            $data_a['status'] = "error";
            $data_a['message'] = 'Caught exception: ' .  $e->getMessage();
        }
        /* ----------------------------------------------------------- */
        // $client = new Client();
        // $response = $client->post($url . $post, $pass);
        // $stream = $response->getBody();
        // $contents = $stream->getContents(); // returns all the contents
        // $contents = $stream->getContents(); // empty string
        // $stream->rewind(); // Seek to the beginning
        // $contents = $stream->getContents(); // returns all the contents
        // $return = json_decode($contents);
        // dd($return);
        /* ----------------------------------------------------------- */
        // RequestForm::render_post($pass, $url . $post);
        /* ----------------------------------------------------------- */
        return Redirect::to("/mlm/wallet/vmoney")->with($data_a["status"], $data_a["message"]);
    }
}