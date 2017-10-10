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
use Mail;
use Illuminate\Pagination\LengthAwarePaginator;

class Press_Release_Controller extends Member
{
    
    public function press_create_email()
    {

    	return view("member.email_system.create_press_release");
    }

    public function choose_recipient()
    {
			$recipientResult = Tbl_press_release_recipient::select("*");
            if(Request::input("recipient_name") != "")
            {
            	$recipientResult = $recipientResult->where("recipient_name",Request::input("recipient_name"));
            }

            if(Request::input("recipient_email_address") != "")
            {
            	// dd(Request::input());
            	$recipientResult = $recipientResult->where('recipient_email_address',Request::input('recipient_email_address'));    	
            }

            if(Request::input("recipient_position") != "")
            {
            	$recipientResult = $recipientResult->where('recipient_position',Request::input('recipient_position'));
            }

            if(Request::input("recipient_group") != "")
            {
            	$recipientResult = $recipientResult->where('group_name',Request::input('recipient_group'));
            }

            $data["_recipient_list"] = $recipientResult->paginate(7); 
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

    public function add_recipient()
    {
    	$insert['recipient_email_address']=Request::input('recipient');
    	Tbl_press_release_recipient::insert($insert);
    	return json_encode("success");
    }


    public function view_send_email()
    {
    	 $data["_email_list"]=Tbl_press_release_email::get();
    	return view("member.email_system.send_email_press_release",$data);
    }

    public function send_email(Request $request)
    {
    	/*dd(Request::input("content"));*/
    	$data['tinymce_content'] = Request::input('content');
    	$data['from']=Request::input('from');
    	$data['to']=Request::input('to');
    	$data['subject']=Request::input('title');
    	Mail::send('member.email_system.email',$data, function($message) use ($data){
 
    		$message->from($data['from']);
    		$message->to($data['to']);
    		$message->subject($data['subject']);
      });
    	return json_encode("success");
	}
    public function press_view_email()
    {
    	
    	return view("member.email_system.view_press_release");
    }






}