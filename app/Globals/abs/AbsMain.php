<?php 

namespace App\Globals\abs;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
class AbsMain
{
    public static function get_balance($base_uri, $base_account_id, $base_user_name, $base_password)
    {
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
            if(isset($data_decoded->result))
            {
            	$data_a['result'] = $data_decoded->result;
            }
            
        }
        catch (\Exception $e) 
        {
            $data_a['status'] = 0;
            $data_a['message'] = 'Caught exception: ' .  $e->getMessage();
        }
        return $data_a;
    }

    public static function get_balance_client($base_uri, $base_account_id, $base_user_name, $base_password, $client_account_id)
    {
        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'application/x-www-form-urlencoded', 
                    'Credentials' => '{"account_id":"'.$base_account_id.'","username":"'.$base_user_name.'","password":"'.$base_password.'"}',
                    'contents' => '',
                    'name' => ''];

        $headers = ['multipart' => [], 'headers' => $headers];    
        
        $client = new Client([
            'base_uri' => $base_uri,
            'timeout'  => 10.0,
        ], $headers);

        try 
        {
            $uri = $base_uri . '/api/wallet/' . $client_account_id ;
            $request = new Request('GET', $uri);
            $response = $client->send($request, $headers);
            $body = $response->getBody();
            $data = $body->read(1024);
            $data_decoded = json_decode($data);

            $data_a['status'] = $data_decoded->status;
            $data_a['message'] = $data_decoded->message;
            if(isset($data_decoded->result))
            {
                $data_a['result'] = $data_decoded->result;
            }
        }
        catch (\Exception $e) 
        {
            $data_a['status'] = 0;
            $data_a['message'] = 'Caught exception: ' .  $e->getMessage();
        }
        return $data_a;
    }

    public static function transfer_wallet($base_uri, $base_account_id, $base_user_name, $base_password, $client_account_id, $amount)
    {
        $data[0]['key'] = "account_id";
        $data[0]['value'] = "ABS-0008";
        $data[0]['type'] = "text";
        $data[0]['enabled'] = true;
        $data[0]['contents'] = '';
        $data[0]['name'] = '';

        $data[1]['key'] = "amount";
        $data[1]['value'] = "1000";
        $data[1]['type'] = "text";
        $data[1]['enabled'] = true;
        $data[1]['contents'] = '';
        $data[1]['name'] = '';
        // $data = '{"key": "account_id","value": "ABS-0008","type": "text","enabled": true},{"key": "amount","value": "1000","type": "text","enabled": true}';

        $headers = ['Connection'=> 'keep-alive', 
                    'Content-Type' => 'application/x-www-form-urlencoded', 
                    'Credentials' => '{"account_id":"'.$base_account_id.'","username":"'.$base_user_name.'","password":"'.$base_password.'"}',
                    'contents' => '',
                    'name' => ''
                    ];

          $headers = 
          [
            'form_params' => 
                [
                    'account_id' => $client_account_id,
                    'amount' => $amount,
                ], 
            'headers' => $headers, 
            'contents' => '', 
            'name' => ''
        ];      
        // dd($headers);
        $client = new Client([
            'base_uri' => $base_uri,
            'timeout'  => 10.0,
        ], $headers);

        try 
        {
            $uri = $base_uri . '/api/wallet';
            // dd($uri);
            $request = new Request('POST', $uri);

            $response = $client->send($request, $headers);
            $body = $response->getBody();
            $data = $body->read(1024);
            $data_decoded = json_decode($data);

            $data_a['status'] = $data_decoded->status;
            $data_a['message'] = $data_decoded->message;
            if(isset($data_decoded->result))
            {
                $data_a['result'] = $data_decoded->result;
            }
            
        }
        catch (\Exception $e) 
        {
            $data_a['status'] = 0;
            $data_a['message'] = 'Caught exception: ' .  $e->getMessage();
        }
        return $data_a;
    }
}

