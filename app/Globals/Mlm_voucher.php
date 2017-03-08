<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_item;
use App\Models\Tbl_item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_membership_code_invoice;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_membership_package_has;
use App\Models\Tbl_voucher;
use App\Models\Tbl_voucher_item;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use App\Globals\Membership_code;

use Schema;
use Session;
use DB;

class Mlm_voucher
{
	public static function give_voucher_mem_code($invoice_id)
	{
		$voucher_invoice = Tbl_membership_code_invoice::where('membership_code_invoice_id', $invoice_id)->first();
		if($voucher_invoice != null)
		{

			if($voucher_invoice->membership_code_product_issued == 0)
			{
				$membership_codes = Tbl_membership_code::where('membership_code_invoice_id', $invoice_id)->package()->get();
				$items= [];
				$insert_voucher = 0;
				foreach($membership_codes as $value)
				{
					$package_product = Tbl_membership_package_has::where('membership_package_id', $value->membership_package_id)->get();

					foreach($package_product as $key2 => $value2)
					{
						$package_a  = Tbl_membership_package::where('membership_package_id', $value->membership_package_id)->first();
						if($package_a->membership_package_is_gc == 0)
						{

							if(isset($items[$value2->item_id]))
							{
								$items[$value2->item_id] += $value2->membership_package_has_quantity;
							}
							else
							{
								$items[$value2->item_id] = $value2->membership_package_has_quantity;
							}
							$insert_voucher = 1;
						}
					}
				}
				if($insert_voucher == 1)
				{
					$insert['voucher_code'] = Membership_code::random_code_generator(6);
					$insert['voucher_code_type'] = 0;
					$insert['voucher_invoice_membership_id'] = $invoice_id;
					$insert['voucher_customer'] = $voucher_invoice->customer_id;
					$insert['voucher_claim_status'] = 0;
					$id = Tbl_voucher::insertGetId($insert);
					foreach($items as $key => $item)
					{
						$insert_item[$key]['voucher_id'] = $id;
						$insert_item[$key]['item_id'] = $key;
						$insert_item[$key]['voucher_item_quantity'] = $item;
						
					}
					if(isset($insert_item))
					{
						Tbl_voucher_item::insert($insert_item);
					}
				}
			}
			
			
		}
	}
	public static function give_voucher_prod_code($invoice_id)
	{
		$voucher_invoice = Tbl_item_code_invoice::where('item_code_invoice_id', $invoice_id)->first();
		if($voucher_invoice != null)
		{
			if($voucher_invoice->item_code_product_issued == 0)
			{
				$product_codes = Tbl_item_code::where('item_code_invoice_id', $invoice_id)->item()->get();
				$items= [];
				foreach($product_codes as $key2 => $value2)
				{
					if(isset($items[$value2->item_id]))
					{
						$items[$value2->item_id] += 1;
					}
					else
					{
						$items[$value2->item_id] = 1;
					}
				}

				$insert['voucher_code'] = Membership_code::random_code_generator(6);
				$insert['voucher_code_type'] = 0;
				$insert['voucher_invoice_product_id'] = $invoice_id;
				$insert['voucher_customer'] = $voucher_invoice->customer_id;
				$insert['voucher_claim_status'] = 0;
				$id = Tbl_voucher::insertGetId($insert);
				foreach($items as $key => $item)
				{
					$insert_item[$key]['voucher_id'] = $id;
					$insert_item[$key]['item_id'] = $key;
					$insert_item[$key]['voucher_item_quantity'] = $item;
				}
				if(isset($insert_item))
				{
					Tbl_voucher_item::insert($insert_item);
				}
			}
		}
	}
}