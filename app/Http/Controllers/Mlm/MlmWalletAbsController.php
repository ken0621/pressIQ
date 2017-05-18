<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use App\Models\Tbl_voucher;
use App\Models\Tbl_membership_code_invoice;
use App\Models\Tbl_membership_code;
use Crypt;
use Redirect;
// use Request;
use View;
use App\Globals\abs\AbsMain;
use App\Models\Tbl_mlm_gc;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
class MlmWalletAbsController extends Mlm
{
    public function index()
    {
        $data = [];
        // return $this->get_balance();
        return view('mlm.tours.index', $data);
    }
    public function transfer()
    {
        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'application/x-www-form-urlencoded', 
                    'Credentials' => '{"account_id":"ABS-0019","username":"philtech","password":"CxxApx6CsrK6r2yr"}'   
                        
                    ,'contents' => '', 'name' => ''];
        // $headers = ['multipart' => ['name' => [ 'contents' => '', 'name' => '' ],'contents'=> [ 'contents' => '', 'name' => ''], 'headers' => $headers], 'headers' => $headers];
        $headers = ['multipart' => ['headers' => $headers], 'headers' => $headers];
        // dd($headers);
        $client = new Client([
            'base_uri' => 'http://staging.tripoption.tours',
            'timeout'  => 10.0,
        ], $headers);

        // $response = $client->request('GET', '/api/wallet/ABS-0019', $headers);

        try 
        {
            // $request =  $client->request('GET', '/api/wallet/ABS-0019', $headers);
            // $response = $client->send($request, ['timeout' => 10]);
            $request = new Request('GET', 'http://staging.tripoption.tours/api/wallet/ABS-0019');
            $response = $client->send($request, $headers);
            $body = $response->getBody();
            $data = $body->read(1024);
            $data_decoded = json_decode($data);
            dd($data_decoded);

            $promise = $client->getAsync('/api/wallet/ABS-0019', $headers);
            $message = '';
            $promise->then(
                function (ResponseInterface $res) {
                    echo $res->getStatusCode() . "\n";
                    $message = $e->getStatusCode();
                },
                function (RequestException $e) {
                    echo $e->getMessage() . "\n";
                    $message = $e->getMessage();
                    echo $e->getRequest()->getMethod();
                }
            );
            // dd($message);
        }
        catch (\Exception $e) 
        {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }
    public function get_balance()
    {
        $base_uri = 'http://staging.tripoption.tours';
        $base_account_id = 'ABS-0019';
        $base_user_name = 'philtech';
        $base_password = 'CxxApx6CsrK6r2yr';

        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'application/x-www-form-urlencoded', 
                    'Credentials' => '{"account_id":"'.$base_account_id.'","username":"'.$base_user_name.'","password":"'.$base_password.'"}',
                    'contents' => '',
                    'name' => ''];

        $headers = ['multipart' => ['headers' => $headers], 'headers' => $headers];    
        
        $client = new Client([
            'base_uri' => $base_uri,
            'timeout'  => 10.0,
        ], $headers);

        try 
        {
            $uri = $base_uri . '/api/wallet/' . $base_account_id ;
            $request = new Request('GET', $uri);
            $response = $client->send($request, $headers);
            $body = $response->getBody();
            $data = $body->read(1024);
            $data_decoded = json_decode($data);

            $data_a['status'] = $data_decoded->status;
            $data_a['message'] = $data_decoded->message;
            $data_a['result'] = $data_decoded->result;
        }
        catch (\Exception $e) 
        {
            $data_a['status'] = 0;
            $data_a['message'] = 'Caught exception: ' .  $e->getMessage();
        }
        return $data_a;
    }

    public function update_info()
    {
        // return $_POST;
        $tour_Wallet_a_account_id = $_POST['tour_Wallet_a_account_id'];
        $tour_wallet_a_username = $_POST['tour_wallet_a_username'];
        $tour_wallet_a_base_password = $_POST['tour_wallet_a_base_password'];
        $base_uri = Self::$shop_info->shop_wallet_tours_uri;
        $status = AbsMain::get_balance($base_uri, $tour_Wallet_a_account_id, $tour_wallet_a_username, $tour_wallet_a_base_password);

        if($status['status'] == 1)
        {
            return json_encode($status);
        }
        else
        {
            return json_encode($status);
        }
        
    }
}