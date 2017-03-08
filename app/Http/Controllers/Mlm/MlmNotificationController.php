<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

use App\Models\Tbl_mlm_slot_wallet_log;

class MlmNotificationController extends Mlm
{
    public function index()
    {
    	// return Self::show_maintenance();

    	$data = [];
    	$data['report'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
        ->orderBy('wallet_log_notified', 'ASC')
        ->orderBy('wallet_log_id', 'DESC')
        
        ->sponsorslot()
        ->paginate(10);
        foreach($data['report'] as $value)
        {
            $update['wallet_log_notified'] = 1;
            Tbl_mlm_slot_wallet_log::where('wallet_log_id', $value->wallet_log_id)->update($update);   
        }
        // dd($data);
    	return view('mlm.notification.notification', $data);
    }
}