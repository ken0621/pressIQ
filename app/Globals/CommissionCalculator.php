<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_commission;
use App\Models\Tbl_commission_item;
use App\Models\Tbl_commission_invoice;
use App\Models\Tbl_customer_invoice;

use Carbon\carbon;
use DB;

/**
 * 
 *
 * @author Arcylen
 */

class CommissionCalculator
{
	public static function create($shop_id, $comm, $comm_item)
	{
		$comm['shop_id'] = $shop_id;
		$commission_id = Tbl_commission::insertGetId($comm);

		$comm_item['commission_id'] = $commission_id;
		$comm_item_id = Tbl_commission_item::insertGetId($comm_item);

        $customer_info['customer_id']       = $comm['customer_id'];
        $customer_info['customer_email']    = $comm['customer_email'];

        $invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
        $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $invoice_info['invoice_date']       = datepicker_input(Request::input('inv_date'));
        $invoice_info['invoice_due']        = datepicker_input(Request::input('inv_due_date'));
        $invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

        $invoice_other_info                 = [];
        $invoice_other_info['invoice_msg']  = Request::input('inv_message');
        $invoice_other_info['invoice_memo'] = Request::input('inv_memo');

        $total_info                         = [];
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['total_discount_type']  = Request::input('inv_discount_type');
        $total_info['total_discount_value'] = Request::input('inv_discount_value');
        $total_info['taxable']              = Request::input('taxable');

		die(var_dump($comm_item_id));
		
	}
}