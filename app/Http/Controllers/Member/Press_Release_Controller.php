<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use Session;
use Redirect;
use Request;
use Response;
use Input;
use App\Models\Tbl_shop;
use App\Models\Tbl_press_release_email;
use App\Models\Tbl_press_release_recipient;
use App\Models\Tbl_press_release_email_sent;
use Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Globals\Settings;

class Press_Release_Controller extends Member
{
    
    public function press_create_email()
    {

    	return view("member.email_system.create_press_release");
    }

    public function choose_recipient()
    {
			$recipientResult = Tbl_press_release_recipient::select("*");
    
            if(Request::input("title_of_journalist") != "")
            {
            	$recipientResult = $recipientResult->whereIn('title_of_journalist',Request::input('title_of_journalist'));
            }

            if(Request::input("country") != "")
            {
                $recipientResult = $recipientResult->whereIn('country',Request::input('country'));
            }

            if(Request::input("industry_type") != "")
            {
                $recipientResult = $recipientResult->whereIn('industry_type',Request::input('industry_type'));
            }

            $data["_recipient_list"] = $recipientResult->get();
            $data["_recipient_country"] = $recipientResult->select('country')->distinct()->get();
            $data["_title_of_journalist"] = $recipientResult->select('title_of_journalist')->distinct()->get();
            $data["_type_of_industry"] = $recipientResult->select('industry_type')->distinct()->get();
            return view("member.email_system.choose_recipient",$data);
    }


    public function save_email()
    {
        $insert['email_title'] = Request::input('title');
    	$insert['email_content'] = Request::input('content');
    	$insert['email_subject']=Request::input('subject');
    	$insert['email_time'] = date('Y-m-d');
    	Tbl_press_release_email::insert($insert);
    	return json_encode("success");



    }

    public function view_send_email()
    {
         $data["_email_list"]=Tbl_press_release_email::get();
    	 $data["sent_email"] = Request::input('sent_email');
    	return view("member.email_system.send_email_press_release",$data);
    }

    public function send_email(Request $request)
    {
            Settings::set_mail_setting($user_info->shop_id);
        try 
        {
            $insert['email_content'] = Request::input('content');
            $insert['from']=Request::input('from');
            $insert['to']=Request::input('to');
            /*$insert['to']=explode(",",Request::input('to'));*/
            $insert['email_title']=Request::input('title');
            $insert['email_subject']=Request::input('subject');
            $insert['email_time'] = date('Y-m-d');
            Tbl_press_release_email_sent::insert($insert);

            $data['tinymce_content'] = Request::input('content');
            $data['from']=Request::input('from');
            $data['to']=explode(",",Request::input('to'));
            $data['subject']=Request::input('subject');
            foreach($data['to'] as $to)
            {
                $data['to'] = $to;
                Mail::send('member.email_system.email',$data, function($message) use ($data)
                {
                    $message->from($data['from']);
                    $message->to($data['to']);
                    $message->subject($data['subject']);
                });  
            }
       
            return json_encode("success"); 
        } 
        catch (\Exception $e) 
        {
            dd($e->getMessages());
        }
        
	}
    public function email_sent()
    {
    	$data['_sent_email']=Tbl_press_release_email_sent::get();
    	return view("member.email_system.email_sent_press_release",$data);
    }

    public function email_list()
    {
        $data['_list_email']=Tbl_press_release_email::get();
        return view("member.email_system.email_list_press_release",$data);
    }

     public function recipient_list()
    {
        $data['_list_recipient']=Tbl_press_release_recipient::get();
        return view("member.email_system.recipient_list_press_release",$data);
    }

    public function add_recipient()
    {
        $insert['recipient_name'] = Request::input('name');
        $insert['recipient_email_address']=Request::input('email');
        $insert['recipient_position'] = Request::input('position');
        $insert['group_name'] = Request::input('group');
        Tbl_press_release_recipient::insert($insert);
        return 'success';
        
    }

    /*public function get_recipient_info()
    {
        $email_address=

    }
*/
    public function analytics()
    {
        $curl = curl_init();

          curl_setopt_array($curl, array(
          CURLOPT_URL => "https://mandrillapp.com/api/1.0/users/info.json?key=cKQiemfNNB-5xm98HhcNzw",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: c2fb288c-3f82-02af-4779-e0f682f5f8a8"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
          echo "cURL Error #:" . $err;
        } 
        else 
        {
        $data['array'] = json_decode($response);
        dd($data);
        }
        return view("member.email_system.analytics_press_release",$data);
    }
}