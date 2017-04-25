<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Session;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_repurchase;
use App\Globals\Mlm_repurchase_member;

use App\Models\Tbl_warehouse;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_item_code;
use App\Models\Tbl_mlm_slot;
class MlmRepurchaseController extends Mlm
{
    public function index()
    {
    	$data["_item"] = Mlm_repurchase_member::get_all_items(Self::$shop_id, Self::$slot_id);
        $data["cart"] = $this->cart();

    	return view('mlm.repurchase.repurchase', $data);
    }

    public function cart()
    {
        $data["_cart"] = Mlm_repurchase_member::get_item_cart();

        return view('mlm.repurchase.repurchase_cart', $data);
    }

    public function add_cart()
    {
        $item_id = Request::input("item_id");
        $quantity = Request::input("quantity");
        $slot = Tbl_mlm_slot::where('slot_id', Self::$slot_id)->first();
        if ($slot) 
        {
            Mlm_repurchase_member::add_to_cart($item_id, $quantity, $slot->slot_membership);
        }
        else
        {
            Mlm_repurchase_member::add_to_cart($item_id, $quantity);
        }

        echo json_encode("success");
    }
}