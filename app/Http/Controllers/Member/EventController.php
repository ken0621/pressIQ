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
		$data['_event'] = ShopEvent::get($this->user_info->shop_id);
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
		$insert['event_date']        = datepicker_input($request->event_date);
		$insert['event_description'] = $request->event_description;

		$rules["event_title"]           = "required";
        $rules["event_sub_title"]   	= "required";
        $rules["event_date"]   		    = "required";
        $rules["event_description"]  	= "required";

        $validate = Validator::make($insert, $rules);

		$attendee = '';
		if($request->event_member && $request->event_guest)
		{
			$attendee = 'all';
		}
		else if($request->event_member)
		{
			$attendee = 'members';
		}
		else if($request->event_guest)
		{
			$attendee = 'guest';
		}

		$insert['event_thumbnail_image']	 = $request->event_thumbnail_image;
		$insert['event_banner_image'] 		 = $request->event_banner_image;
		$insert['event_attendee']  		     = $attendee;
		$insert['event_shop_id']			 = $this->user_info->shop_id;

        $return['status'] = null;
        $return['status_message'] = null;
        if(!$validate->fails()) 
        {
        	$id = ShopEvent::create_event($insert);
        	if(is_numeric($id))
        	{
        		$return['status'] = 'success';
        		$return['call_function'] = 'success_event';
        	}
        	else
        	{
	        	$return['status'] = 'error';
	        	$return['status_message'] = "Something wen't wrong";        		
        	}
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