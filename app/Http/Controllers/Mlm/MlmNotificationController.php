<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;

use App\Models\Tbl_mlm_slot_wallet_log;

class MlmNotificationController extends Mlm
{
    public function index()
    {

    	$data = [];
    	
    	$search_slot = Request::input('search_slot');
    	if($search_slot)
    	{
    	    $slot_no = Self::$slot_now->slot_no;
    	    $data['report'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->orderBy('wallet_log_notified', 'ASC')
            ->orderBy('wallet_log_id', 'DESC')
            ->sponsorslot()
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->where(DB::raw("CONCAT(tbl_customer.first_name, ' ', tbl_customer.middle_name, ' ', tbl_customer.last_name, ' ', tbl_mlm_slot.slot_no )"), 'LIKE', "%".$search_slot."%")
            ->paginate(10);  
    	}
    	else
    	{
    	    $data['report'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->orderBy('wallet_log_notified', 'ASC')
            ->orderBy('wallet_log_id', 'DESC')
            ->sponsorslot()
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->paginate(10);
    	}
    	
        $data['search_slot'] = $search_slot;
        

        foreach($data['report'] as $value)
        {
            $update['wallet_log_notified'] = 1;
            Tbl_mlm_slot_wallet_log::where('wallet_log_id', $value->wallet_log_id)->update($update);   
        }
    	return view('mlm.notification.notification', $data);
    }
    public function search()
    {
        
    }
}