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
        return $this->transfer();
        return view('mlm.tours.index', $data);
    }
    public function transfer()
    {
        $data['account_id'] = 'ABS-0019';
        $data['amount'] = '100.00';
        $headers = [];         
        // $headers = json_encode($headers);
        $api = AbsMain::$mainurl;

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $api,
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]); 
        $credentials = [
        'headers' => [
            'Content-Type' => 'Content-Type: application/x-www-form-urlencoded',
            'Credentials' => [ 
                'account_id' => 'ABS-0019',
                'username' => 'philtech',
                'password' => 'CxxApx6CsrK6r2yr'
                ]
            ],
        'requests' => []    
        ];
        $request_a = [];
        try
        {
            $response = $client->request('GET', '/api/wallet/ABS-0019', 
            [
            'json' => '"headers": "Content-Type: application/x-www-form-urlencoded\nCredentials: {\"account_id\":\"ABS-0019\",\"username\":\"philtech\",\"password\":\"CxxApx6CsrK6r2yr\"}\n"'
            ]);
            dd($response);
        }
        catch (\Exception $e) 
        {
            return $e->getMessage();
        }
        dd(1);
        try {
            $request = new Request('GET', '/api/wallet');
            $response = $client->request('GET', '/api/wallet/ABS-0019');
            dd($response);
            // $client->post('/api/wallet', $headers);
            // $response = $client->send($request, ['timeout' => 10]);
            $body = $response->getBody();
        }
        catch (\Exception $e) 
        {
            return $e->getMessage();
        }

        $request = new Request('POST', '/api/wallet', $headers);
        $response = $client->send($request, ['timeout' => 10]);
        $body = $response->getBody();
        dd(1);
        dd($body);


        
        $response = $client->request('POST', '/api/wallet', $data);

        // $promise = $client->postAsync($api);
        dd($response);
    }
}