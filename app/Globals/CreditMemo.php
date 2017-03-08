<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_credit_memo;
use DB;
use Session;
use Carbon\Carbon;

class CreditMemo
{
	public static function postCM($customer_info, $item_info)
	{
		$insert_cm["cm_customer_id"] = $customer_info["cm_customer_id"];
		$insert_cm["cm_customer_email"] = $customer_info["cm_customer_email"];
		$insert_cm["cm_date"] = $customer_info["cm_date"];
		$insert_cm["cm_message"] = $customer_info["cm_message"];
		$insert_cm["cm_memo"] = $customer_info["cm_memo"];
		$insert_cm["cm_amount"] = $customer_info["cm_amount"];
		$insert_cm["date_created"] = Carbon::now();

		$cm_id = Tbl_credit_memo::insertGetId($insert_cm);

		CreditMemo::insert_cmline($cm_id, $item_info);

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

		Tbl_credit_memo_line::where("cmline_cm_id",$cm_id)->delete();
		CreditMemo::insert_cmline($cm_id, $item_info);

	}
	public static function insert_cmline($cm_id, $item_info)
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
		}
	}
}
