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

class Press_Release_Controller extends Member
{
    
    public function press_create_email()
    {

    	return view("member.email_system.create_press_release");
    }

    public function choose_recipient(Request $request)
    {
			$recipientResult = Tbl_press_release_recipient::select("*");
            if(Request::input("company_name") != "")
            {
            	$recipientResult = $recipientResult->where("company_name",Request::input("company_name"));
            }

            if(Request::input("name") != "")
            {
            	// dd(Request::input());
            	$recipientResult = $recipientResult->where('name',Request::input('name'));    	
            }

            if(Request::input("position") != "")
            {
            	$recipientResult = $recipientResult->where('position',Request::input('position'));
            }

            if(Request::input("title_of_journalist") != "")
            {
            	$recipientResult = $recipientResult->where('title_of_journalist',Request::input('title_of_journalist'));
            }

            if(Request::input("country") != "")
            {
                $recipientResult = $recipientResult->where('country',Request::input('country'));
            }

            if(Request::input("industry_type") != "")
            {
                $recipientResult = $recipientResult->where('industry_type',Request::input('industry_type'));
            }


            $data["_recipient_list"] = $recipientResult->get();
            $data["_recipient_country"] = $recipientResult->select('country')->distinct()->get();

            return view("member.email_system.choose_recipient",$data);

    
     
    }


    public function save_email()
    {
    	$insert['email_content'] = Request::input('content');
    	$insert['email_title']=Request::input('subject');
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
        try 
        {
            $insert['email_content'] = Request::input('content');
            $insert['from']=Request::input('from');
            $insert['to']=Request::input('to');
            /*$insert['to']=explode(",",Request::input('to'));*/
            $insert['email_title']=Request::input('subject');
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
                    $message->to("edwardguevarra2003@gmail");
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


}