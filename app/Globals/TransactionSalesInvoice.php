<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
use App\Globals\CustomerWIS;
use App\Globals\Warehouse2;
/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionSalesInvoice
{
	public static function countTransaction($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_customer_id",$customer_id)->where("est_status","accepted")->count();
	}
	public static function countUndeliveredSalesInvoice($shop_id, $customer_id)
	{
		return Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_customer_id', $customer_id)->where('is_sales_receipt',0)->where('item_delivered',0)->count();
	}
	public static function getUndeliveredSalesInvoice($shop_id, $customer_id)
	{
		return Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_customer_id', $customer_id)->where('is_sales_receipt',0)->where('item_delivered',0)->get();
	}
	public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
	{
		$data = Tbl_customer_invoice::customer()->where('inv_shop_id', $shop_id)->where('is_sales_receipt',0);

		if($search_keyword)
		{
			$data->where(function($q) use ($search_keyword)
            {
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("new_inv_id", "LIKE", "%$search_keyword%");
                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");
            });
		}

		if($status != 'all')
		{
			$tab = 0;
			if($status == 'open')
			{
				$tab = 0;
			}
			if($status == 'closed')
			{
				$tab = 1;
			}
			$data->where('inv_is_paid',$tab);
		}
		if($paginate)
		{
			$data = $data->paginate($paginate);
		}
		else
		{
			$data = $data->get();
		}

		return $data;
	}
	public static function info($shop_id, $invoice_id)
	{
		return Tbl_customer_invoice::customer()->where("inv_shop_id", $shop_id)->where("inv_id", $invoice_id)->first();
	}
	public static function info_item($invoice_id)
	{
		return Tbl_customer_invoice_line::um()->where("invline_inv_id", $invoice_id)->get();		
	}

	public static function postUpdate($invoice_id, $shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
			$return  = null; 
			$ins['inv_shop_id']                  = $shop_id;  
			$ins['inv_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['inv_customer_email']           = $insert['customer_email'];
	        $ins['inv_customer_billing_address'] = $insert['customer_address'];
	        $ins['inv_terms_id']                 = $insert['customer_terms'];
	        $ins['inv_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['inv_due_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
	        $ins['ewt']                          = $insert['customer_ewt'];
	        $ins['inv_discount_type']            = $insert['customer_discounttype'];
	        $ins['inv_discount_value']           = $insert['customer_discount'];
	        $ins['taxable']                      = $insert['customer_tax'];
	        $ins['inv_message']                  = $insert['customer_message'];
	        $ins['inv_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* DISCOUNT */
	        $discount = $insert['customer_discount'];
	        if($insert['customer_discounttype'] == 'percent') $discount = (convertToNumber($insert['customer_discount']) / 100) * $subtotal_price;

	        /* TAX */
	        $tax = (collect($insert_item)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

	        /* EWT */
	        $ewt = $subtotal_price * convertToNumber($insert['customer_ewt']);

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

	        $ins['inv_subtotal_price']           = $subtotal_price;
	        $ins['inv_overall_price']            = $overall_price;


	        /* INSERT INVOICE HERE */
	        Tbl_customer_invoice::where('inv_id', $invoice_id)->update($ins);
	        // $invoice_id = 0;

	        /* Transaction Journal */
	        $entry["reference_module"]  = 'invoice';
	        $entry["reference_id"]      = $invoice_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = $tax;
	        $entry["discount"]          = $discount;
	        $entry["ewt"]               = $ewt;

			Tbl_customer_invoice_line::where("invline_inv_id", $invoice_id)->delete();
	        $return = Self::insertline($invoice_id, $insert_item, $entry);
	        $return = $invoice_id;

			$warehouse_id = Warehouse2::get_current_warehouse($shop_id);
	        /* UPDATE INVENTORY HERE */
			AccountingTransaction::inventory_consume_update($shop_id, $warehouse_id, 'sales_invoice', $invoice_id); 
			AccountingTransaction::consume_inventory($shop_id, $warehouse_id, $insert_item, 'sales_invoice', $invoice_id, 'Consume upon creating SALES INVOICE '.$ins['transaction_refnum']);

		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
			$return  = null; 
			$ins['inv_shop_id']                  = $shop_id;  
			$ins['inv_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['inv_customer_email']           = $insert['customer_email'];
	        $ins['inv_customer_billing_address'] = $insert['customer_address'];
	        $ins['inv_terms_id']                 = $insert['customer_terms'];
	        $ins['inv_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['inv_due_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
	        $ins['ewt']                          = $insert['customer_ewt'];
	        $ins['inv_discount_type']            = $insert['customer_discounttype'];
	        $ins['inv_discount_value']           = $insert['customer_discount'];
	        $ins['taxable']                      = $insert['customer_tax'];
	        $ins['inv_message']                  = $insert['customer_message'];
	        $ins['inv_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

			$ins['item_delivered'] = 0;
	        if(CustomerWIS::settings($shop_id) == 0)
			{
				$ins['item_delivered'] = 1;
			}

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* DISCOUNT */
	        $discount = $insert['customer_discount'];
	        if($insert['customer_discounttype'] == 'percent') $discount = (convertToNumber($insert['customer_discount']) / 100) * $subtotal_price;

	        /* TAX */
	        $tax = (collect($insert_item)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

	        /* EWT */
	        $ewt = $subtotal_price*convertToNumber($insert['customer_ewt']);

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

	        $ins['inv_subtotal_price']           = $subtotal_price;
	        $ins['inv_overall_price']            = $overall_price;


	        /* INSERT INVOICE HERE */
	        $invoice_id = Tbl_customer_invoice::insertGetId($ins);
	        // $invoice_id = 0;

	        /* Transaction Journal */
	        $entry["reference_module"]  = 'invoice';
	        $entry["reference_id"]      = $invoice_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = $tax;
	        $entry["discount"]          = $discount;
	        $entry["ewt"]               = $ewt;

	        $return = Self::insertline($invoice_id, $insert_item, $entry);
	        $return = $invoice_id;

			$warehouse_id = Warehouse2::get_current_warehouse($shop_id);
			AccountingTransaction::consume_inventory($shop_id, $warehouse_id, $insert_item, 'sales_invoice', $invoice_id, 'Consume upon creating SALES INVOICE '.$ins['transaction_refnum']);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function insertline($invoice_id, $insert_item, $entry)
	{
		$itemline = null;
		$return = null;
		foreach ($insert_item as $key => $value) 
		{	
	        /* DISCOUNT PER LINE */
	        $discount       = $value['item_discount'];
	        $discount_type  = 'fixed';
	        if(strpos($discount, '%'))
            {
            	$discount       = substr($discount, 0, strpos($discount, '%')) / 100;
                $discount_type  = 'percent';
            }

			$itemline[$key]['invline_inv_id'] 			= $invoice_id;
			$itemline[$key]['invline_service_date'] 	= $value['item_servicedate'];
			$itemline[$key]['invline_item_id'] 			= $value['item_id'];
			$itemline[$key]['invline_description'] 		= $value['item_description'];
			$itemline[$key]['invline_um'] 				= $value['item_um'];
			$itemline[$key]['invline_qty'] 				= $value['item_qty'];
			$itemline[$key]['invline_rate'] 			= $value['item_rate'];
			$itemline[$key]['invline_discount'] 		= $discount;
			$itemline[$key]['invline_discount_type'] 	= $discount_type;
			$itemline[$key]['invline_discount_remark'] 	= $value['item_remarks'];
			$itemline[$key]['taxable'] 					= $value['item_taxable'];
			$itemline[$key]['invline_amount'] 			= $value['item_amount'];
			$itemline[$key]['date_created'] 			= Carbon::now();
		}
		if(count($itemline) > 0)
		{
			Tbl_customer_invoice_line::insert($itemline);
			$return = AccountingTransaction::entry_data($entry, $insert_item);
		}

		return $return;
	}
}