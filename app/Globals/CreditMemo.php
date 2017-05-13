<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_credit_memo;
use App\Globals\Accounting;
use App\Globals\Warehouse;
use App\Globals\Item;
use App\Globals\UnitMeasurement;     
use DB;
use Session;
use Carbon\Carbon;

class CreditMemo
{
	public static function cm_amount($inv_id)
	{
		$inv_data = Tbl_customer_invoice::c_m()->where("inv_id",$inv_id)->first();
		$cm_amount = 0;
		if($inv_data != null)
        {
            $cm_amount = $inv_data->cm_amount;
        }
        return $cm_amount;
	}
	public static function postCM($customer_info, $item_info, $inv_id = 0)
	{
		$insert_cm["cm_customer_id"] = $customer_info["cm_customer_id"];
		$insert_cm["cm_customer_email"] = $customer_info["cm_customer_email"];
		$insert_cm["cm_date"] = $customer_info["cm_date"];
		$insert_cm["cm_message"] = $customer_info["cm_message"];
		$insert_cm["cm_memo"] = $customer_info["cm_memo"];
		$insert_cm["cm_amount"] = $customer_info["cm_amount"];
		$insert_cm["date_created"] = Carbon::now();

		$cm_id = Tbl_credit_memo::insertGetId($insert_cm);

		/* Transaction Journal */
        $entry["reference_module"]  = "credit-memo";
        $entry["reference_id"]      = $cm_id;
        $entry["name_id"]           = $customer_info['cm_customer_id'];
        $entry["total"]             = $customer_info["cm_amount"];
        $entry["vatable"]           = '';
        $entry["discount"]          = '';
        $entry["ewt"]               = '';

		CreditMemo::insert_cmline($cm_id, $item_info, $entry);

		if($inv_id != 0)
		{
			$up["credit_memo_id"] = $cm_id;
			Tbl_customer_invoice::where("inv_id",$inv_id)->update($up);
		}
		return $cm_id;
	}

	public static function updateCM($cm_id, $customer_info, $item_info)
	{

		$update_cm["cm_customer_id"] = $customer_info["cm_customer_id"];
		$update_cm["cm_customer_email"] = $customer_info["cm_customer_email"];
		$update_cm["cm_date"] = $customer_info["cm_date"];
		$update_cm["cm_message"] = $customer_info["cm_message"];
		$update_cm["cm_memo"] = $customer_info["cm_memo"];
		$update_cm["cm_amount"] = $customer_info["cm_amount"];
		$update_cm["date_created"] = Carbon::now();

		Tbl_credit_memo::where("cm_id",$cm_id)->update($update_cm);

		/* Transaction Journal */
        $entry["reference_module"]  = "credit-memo";
        $entry["reference_id"]      = $cm_id;
        $entry["name_id"]           = $customer_info['cm_customer_id'];
        $entry["total"]             = $customer_info["cm_amount"];
        $entry["vatable"]           = '';
        $entry["discount"]          = '';
        $entry["ewt"]               = '';

		Tbl_credit_memo_line::where("cmline_cm_id",$cm_id)->delete();
		CreditMemo::insert_cmline($cm_id, $item_info, $entry);

	}
	public static function insert_cmline($cm_id, $item_info, $entry)
	{
		foreach ($item_info as $key => $value) 
		{
			$insert_cmline["cmline_cm_id"] = $cm_id;
			// $insert_cmline["cmline_service_date"] = $value["item_service_date"];
			$insert_cmline["cmline_um"] = $value["um"];
			$insert_cmline["cmline_item_id"] = $value["item_id"];
			$insert_cmline["cmline_description"] = $value["item_description"];
			$insert_cmline["cmline_qty"] = $value["quantity"];
			$insert_cmline["cmline_rate"] = $value["rate"];
			$insert_cmline["cmline_amount"] = $value["amount"];

			Tbl_credit_memo_line::insert($insert_cmline);

			$item_type = Item::get_item_type($value['item_id']);
            /* TRANSACTION JOURNAL */  
            if($item_type != 4)
            { 
	            $entry_data[$key]['item_id']            = $value["item_id"];
	            $entry_data[$key]['entry_qty']          = $value["quantity"];
	            $entry_data[$key]['vatable']            = 0;
	            $entry_data[$key]['discount']           = 0;
	            $entry_data[$key]['entry_amount']       = $value["amount"];
	            $entry_data[$key]['entry_description']  = $value["item_description"];
            }
	        else
	        {
	        	$item_bundle = Item::get_item_in_bundle($value['item_id']);
                if(count($item_bundle) > 0)
                {
                    foreach ($item_bundle as $key_bundle => $value_bundle) 
                    {
                        $item_data = Item::get_item_details($value_bundle->bundle_item_id);
                        $entry_data['b'.$key.$key_bundle]['item_id']            = $value_bundle->bundle_item_id;
                        $entry_data['b'.$key.$key_bundle]['entry_qty']          = $value['quantity'] * (UnitMeasurement::um_qty($value_bundle->bundle_um_id) * $value_bundle->bundle_qty);
                        $entry_data['b'.$key.$key_bundle]['vatable']            = 0;
                        $entry_data['b'.$key.$key_bundle]['discount']           = 0;
                        $entry_data['b'.$key.$key_bundle]['entry_amount']       = $item_data->item_price * $entry_data['b'.$key.$key_bundle]['entry_qty'];
                        $entry_data['b'.$key.$key_bundle]['entry_description']  = $item_data->item_sales_information; 
                    }
                }
	        }
		}
		
		$cm_journal = Accounting::postJournalEntry($entry, $entry_data);
	}
}
