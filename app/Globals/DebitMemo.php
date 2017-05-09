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
use App\Models\Tbl_debit_memo_line;
use App\Models\Tbl_debit_memo;
use App\Globals\Accounting;
use DB;
use Session;
use Carbon\Carbon;

class DebitMemo
{
	public static function postDB($vendor_info, $item_info, $inv_id = 0)
	{
		$insert_db["db_vendor_id"] = $vendor_info["db_vendor_id"];
		$insert_db["db_vendor_email"] = $vendor_info["db_vendor_email"];
		$insert_db["db_date"] = $vendor_info["db_date"];
		$insert_db["db_message"] = $vendor_info["db_message"];
		$insert_db["db_memo"] = $vendor_info["db_memo"];
		$insert_db["db_amount"] = $vendor_info["db_amount"];
		$insert_db["date_created"] = Carbon::now();

		$db_id = Tbl_debit_memo::insertGetId($insert_db);


		DebitMemo::insert_dbline($db_id, $item_info);

		return $db_id;
	}

	public static function updateDB($db_id, $vendor_info, $item_info)
	{

		$update_db["db_vendor_id"] = $vendor_info["db_vendor_id"];
		$update_db["db_vendor_email"] = $vendor_info["db_vendor_email"];
		$update_db["db_date"] = $vendor_info["db_date"];
		$update_db["db_message"] = $vendor_info["db_message"];
		$update_db["db_memo"] = $vendor_info["db_memo"];
		$update_db["db_amount"] = $vendor_info["db_amount"];
		$update_db["date_created"] = Carbon::now();

		Tbl_debit_memo::where("db_id",$db_id)->update($update_db);


		Tbl_debit_memo_line::where("dbline_db_id",$db_id)->delete();
		DebitMemo::insert_dbline($db_id, $item_info);

	}
	public static function insert_dbline($db_id, $item_info)
	{
		foreach ($item_info as $key => $value) 
		{
			$insert_dbline["dbline_db_id"] = $db_id;
			// $insert_dbline["dbline_service_date"] = $value["item_service_date"];
			$insert_dbline["dbline_um"] = $value["um"];
			$insert_dbline["dbline_item_id"] = $value["item_id"];
			$insert_dbline["dbline_description"] = $value["item_description"];
			$insert_dbline["dbline_qty"] = $value["quantity"];
			$insert_dbline["dbline_rate"] = $value["rate"];
			$insert_dbline["dbline_amount"] = $value["amount"];

			Tbl_debit_memo_line::insert($insert_dbline);

		}

	}
}
