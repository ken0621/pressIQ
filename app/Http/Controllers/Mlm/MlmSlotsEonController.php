<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Carbon\Carbon;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_transfer_slot_log;
use App\Models\Tbl_item_code;
use App\Models\Tbl_mlm_slot_wallet_log;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_member;
use App\Globals\Item_code;

class MlmSlotsEonController extends Mlm
{
    public function index()
    {
        $data = [];
        $data['all_slots_p']       = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->membership()->paginate(100);
        $data['customer_info_active'] = Self::$customer_info;
        return view('mlm.eon.index', $data);
    }
    public function update_eon()
    {
        $slot_id = Request::input('slot_id');
        $slot_eon = Request::input('slot_eon');
        $slot_eon_account_no = Request::input('slot_eon_account_no');
        $slot_eon_card_no = Request::input('slot_eon_card_no');
        
        $count_used_slot_eon_account_no = Tbl_mlm_slot::where('slot_eon_account_no', $slot_eon_account_no)->where('slot_id', '!=', $slot_id)->count();
        $count_used_slot_eon_card_no = Tbl_mlm_slot::where('slot_eon_account_no', $slot_eon_card_no)->where('slot_id', '!=', $slot_id)->count();
        if($count_used_slot_eon_account_no == 0 && $count_used_slot_eon_card_no == 0)
        {
            $update['slot_eon']   = $slot_eon;
            $update['slot_eon_account_no'] = $slot_eon_account_no;
            $update['slot_eon_card_no'] = $slot_eon_card_no;
            Tbl_mlm_slot::where('slot_id', $slot_id)->update($update);
            
            $data['status'] = 'success';
            $data['message'] = 'Eon Card Updated';
            
            return json_encode($data);
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'] = 'Eon account no/card no already used';
            return json_encode($data);
        }
    }
}