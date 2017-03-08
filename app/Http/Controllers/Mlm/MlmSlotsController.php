<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_mlm_slot;
class MlmSlotsController extends Mlm
{
    public function index()
    {
    	if(Self::$slot_id != null)
    	{
    		$data = [];
    		$data['all_slots'] = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->get();
    		// dd($data);
    		return view('mlm.slots.index', $data);
    	}
        else
        {
        	return Self::show_no_access();
        }
    }
}