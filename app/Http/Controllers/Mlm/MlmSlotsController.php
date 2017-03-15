<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
class MlmSlotsController extends Mlm
{
    public function index()
    {
    	if(Self::$slot_id != null)
    	{
    		$data = [];
            $data['all_slots_p'] = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->paginate(20);
            $data['active'] = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->where('slot_defaul', 1)->first();
    		// dd($data);
    		return view('mlm.slots.index', $data);
    	}
        else
        {
        	return Self::show_no_access();
        }
    }
    public function set_nickname()
    {
        // return $_POST;
        if(isset($_POST['active_slot']))
        {
            if(isset($_POST['slot_nickname']))
            {
                $customer_id = Self::$customer_id;
                $slot_id = $_POST['active_slot'];
                $nickname = $_POST['slot_nickname'];
                $slot = Tbl_mlm_slot::where('slot_owner', $customer_id)->where('slot_id', $slot_id)->first();
                if(isset($slot->slot_id))
                {
                    if(strlen($nickname) >= 6)
                    {
                        $user_count = Tbl_mlm_slot::where('slot_no', $nickname)->where('slot_owner', '!=', $customer_id)->count();
                        $user_count_2 = Tbl_mlm_slot::where('slot_nick_name', $nickname)->where('slot_owner', '!=', $customer_id)->count();
                        $user_count_3 = Tbl_customer::where('mlm_username', $nickname)->count();
                        $all = $user_count + $user_count_2 + $user_count_3;
                        if($all == 0)
                        {
                            $update['slot_defaul'] = 0;
                            $update['slot_nick_name'] = null;
                            Tbl_mlm_slot::where('slot_owner', $customer_id)->update($update);

                            $update_new['slot_defaul'] = 1;
                            $update_new['slot_nick_name'] = $nickname;
                            Tbl_mlm_slot::where('slot_owner', $slot->slot_owner)->where('slot_id', $slot->slot_id)->update($update_new);
                            $data['message'] ='Slot Nickname/Default slot Changed!';
                            $data['status'] = 'success';
                        }
                        else
                        {
                            $data['message'] ='Nickname Already Taken.';
                            $data['status'] = 'warning';
                        } 
                        
                    }
                    else
                    {
                        $data['message'] ='Nickname Length Must Be Greater Than 6.';
                        $data['status'] = 'warning';
                    }
                }
                else
                {
                    $data['message'] ='Invalid Slot';
                    $data['status'] = 'warning';
                }
            }
            else
            {
                $data['message'] ='Nickname field is required';
                $data['status'] = 'warning';
            }
        }
        else
        {
            $data['message'] ='Slot field is required';
            $data['status'] = 'warning';

        }
        return json_encode($data);
    }
}