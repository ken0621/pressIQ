<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use App\Globals\ShopEvent;
/**
 * 
 *
 * @author ARCYLEN
 */

class EventController extends Member
{
	public function getIndex()
	{
		$data['page'] = 'Events';
		return view('member.manage_page_event.event_list',$data);
	}
	public function getCreate()
	{
		$data['process'] = 'Create';
		$data['action'] = '/member/page/events/create-submit';
		return view('member.manage_page_event.event_create',$data);		
	}
	public function postCreateSubmit(Request $request)
	{
		$insert['event_title']		 = $request->event_title;
		$insert['event_sub_title'] 	 = $request->event_sub_title;
		$insert['event_date']        = $request->event_date;
		$insert['event_description'] = $request->event_description;

		$rules["event_title"]           = "required";
        $rules["event_sub_title"]   	= "required";
        $rules["event_date"]   		    = "required";
        $rules["event_description"]  	= "required";

        $validate = Validator::make($insert, $rules);

        $return['status'] = null;
        $return['status_message'] = null;
        if(!$validate->fails()) 
        {
        	dd(123);
        }
        else
        {
        	$message = '';
            foreach($validate->errors()->all() as $error)
            {
                $message .= "<li>" . $error . "</li>";
            }
        	$return['status'] = 'error';
        	$return['status_message'] = $message;
        }

        return json_encode($return);
	}
}