<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Globals\Accounting;
use App\Globals\Category;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Vendor;

use App\Models\Tbl_mlm_slot;
use App\Globals\Pdf_global;
use PDF;
use App;
use Request;
use Carbon\Carbon;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_membership;

use SnappyImage;
use Response;
use App\Globals\Cards;
class MLM_CardController extends Member
{
    public function all_slot()
    {
        $data = [];
        $shop_id = $this->getShop_Id();
        $data['membership'] = Tbl_membership::where('shop_id', $shop_id)->get();
        return view('member.card.index',$data);
    }
    public function filter()
    {
        // return $_POST;
        $shop_id = $this->getShop_Id();
        $membership_id = Request::input('membership_id');
        $ret = null;
        if($membership_id == 1)
        {
            $card_info = Tbl_mlm_discount_card_log::membership()
            ->whereNotNull('tbl_mlm_discount_card_log.discount_card_customer_holder')
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
            ->leftjoin('tbl_customer_other_info', 'tbl_customer_other_info.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
            ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
            ->get();
            foreach ($card_info as $key => $value) {
                # code...
                $ret .= Cards::discount_card($value);
            }
        }
        else
        {
            $slot_card_printed = Request::input('card_status');
            $all_slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)
            ->where('slot_card_printed', $slot_card_printed)
            ->where('tbl_membership.membership_id', $membership_id)
            ->leftjoin('tbl_customer_other_info', 'tbl_customer_other_info.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->where('tbl_customer_address.purpose', 'billing')
            ->membership()->customer()->get();
            $ret = null;
            foreach ($all_slot as $key => $value) 
            {
                $ret .= Cards::card_all($value);
            }
        }
        // dd($all_slot);
        // return json_encode($all_slot);
        $data['status'] = 'succes';
        $data['append'] = $ret;
        return json_encode($data);
    }
	public function generate($slot_id)
	{
        $shop_id = $this->getShop_Id();

		$slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)
        ->where('tbl_mlm_slot.slot_id', $slot_id)
        ->leftjoin('tbl_customer_other_info', 'tbl_customer_other_info.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            
        ->membership()->customer()->first();
        $card = Cards::card_all($slot);


        return Pdf_global::show_image($card);
	}
	
    public function card()
    {
        $data['color'] = Request::input("color");
        $data['name'] = Request::input("name");
        $data['membership_code'] = Request::input("membership_code");

        return view("card", $data);
    }
    public function done()
    {
        // return $_POST;
        $slot_id = Request::input('slot_id');
        $update['slot_card_printed'] = 1;
        $update['slot_card_issued'] = Carbon::now();
        Tbl_mlm_slot::where('slot_id', $slot_id)->update($update);

        $data['status'] = 'success_done';

        return json_encode($data);
    }
    public function pending()
    {
        // return $_POST;
        $slot_id = Request::input('slot_id');
        $update['slot_card_printed'] = 0;
        $update['slot_card_issued'] = Carbon::now();
        Tbl_mlm_slot::where('slot_id', $slot_id)->update($update);

        $data['status'] = 'success_done';

        return json_encode($data);
    }
}