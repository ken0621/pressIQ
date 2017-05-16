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
        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'application/x-www-form-urlencoded', 
                    'Credentials' => 
                        ['account_id' => 'ABS-0019', 
                        'username' => 'philtech', 
                        'password' => 'CxxApx6CsrK6r2yr']    
                        
                    ,'contents' => '', 'name' => ''];
        
        $contents = 
        $headers = ['multipart' => ['name' => [ 'contents' => '', 'name' => '' ],'contents'=> [ 'contents' => '', 'name' => ''], 'headers' => $headers], 'headers' => $headers];
        // dd($headers);
        // $request = new Request('GET', 'http://staging.tripoption.tours');

        $client = new Client([
            'base_uri' => 'http://staging.tripoption.tours',
            'timeout'  => 10.0,
        ], $headers);

        $response = $client->request('GET', '/api/wallet/ABS-0019', $headers);

        try 
        {
            // $request->send();
            // dd(1);
            // $client->setDefaultOption('headers', $headers);
            // $client->getConfig('headers', $headers);
            // $client->getConfig('headers/Connection', 'keep-alive');
            // dd($client);
            
            dd(2);
            $response = $request->send();
            dd(1);
            $request = new Request('GET', 'http://staging.tripoption.tours/api/wallet/ABS-0019');
            $response = $client->send($request, ['headers' => $headers]);
        }
        catch (\Exception $e) 
        {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }
}