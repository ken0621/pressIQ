<?php
namespace App\Globals;

use App\Models\Tbl_item;
use App\Models\Tbl_item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_mlm_gc;
use App\Models\Tbl_item_code_item;
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_merchant_markup;
use App\Globals\Mlm_voucher;
use App\Globals\Item;
use App\Globals\Item_code;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_gc;
use App\Globals\AuditTrail;
use App\Globals\Mlm_slot_log;
use DB;
use Session;
use Carbon\Carbon;
use Validator;
use App\Models\Tbl_email_template;
use App\Globals\EmailContent;
use App\Globals\Mlm_plan;
use App\Models\Tbl_mlm_item_points;
use App\Globals\Ec_order;
use Mail;
use App\Globals\Accounting;
class Merchant
{
    public function item_code_merchant_mark_up($invoice_id)
    {
        $invoice = Tbl_item_code_invoice::where('item_code_invoice_id', $invoice_id)->first();
        $invoice_item = Tbl_item_code_item::where('item_code_invoice_id', $invoice_id)->get();

        if($invoice && $invoice_item)
        {
            $user = Tbl_user::where('user_id', $invoice->user_id)->first();
            if($user)
            {
                if($user->user_is_merchant == 1)
                {

                    foreach($invoice_item as $key => $value)
                    {
                        $check_if_there_is_mark_up = Tbl_merchant_markup::where('user_id', $invoice->user_id)->where('item_id', $value->item_id)->first();
                        if($check_if_there_is_mark_up)
                        {
                            
                        }
                    }
                }
                
            }

        }
    }
}