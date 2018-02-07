<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_customer_estimate_line;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
use Session;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionSalesReceipt
{
	public static function countTransaction($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_customer_id",$customer_id)->where("est_status","accepted")->count();
	}
	public static function countUndeliveredSalesReceipt($shop_id, $customer_id)
	{
		return Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_customer_id', $customer_id)->where('is_sales_receipt',1)->where('item_delivered',0)->count();
	}
	public static function getUndeliveredSalesReceipt($shop_id, $customer_id)
	{
		return Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_customer_id', $customer_id)->where('is_sales_receipt',1)->where('item_delivered',0)->get();
	}	
	public static function transaction_data($shop_id, $trans_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_id",$trans_id)->first();
	}
	public static function transaction_data_item($trans_id)
	{
		return Tbl_customer_estimate_line::um()->where("estline_est_id",$trans_id)->get();		
	}
	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_customer_invoice::customer()->where('inv_shop_id', $shop_id)->where('inv_is_paid',1)->where('is_sales_receipt',1);

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
	public static function info($shop_id, $sales_receipt_id)
	{
		return Tbl_customer_invoice::customer()->where("inv_shop_id", $shop_id)->where("inv_id", $sales_receipt_id)->first();
	}
	public static function info_item($sales_receipt_id)
	{
		$data = Tbl_customer_invoice_line::invoice_item()->um()->where("invline_inv_id", $sales_receipt_id)->get();
		foreach($data as $key => $value) 
        {
            $qty = UnitMeasurement::um_qty($value->invline_um);

            $total_qty = $value->invline_qty * $qty;
            $data[$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->invline_um);
        }
        return $data;
	}

	public static function postUpdate($sales_receipt_id, $shop_id, $insert, $insert_item = array())
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
	        $ins['inv_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
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

	        $ins['is_sales_receipt']             = 1;
            $ins['inv_payment_applied']		     = $overall_price;
            $ins['inv_is_paid']                  = 1;


	        /* INSERT INVOICE HERE */
	        Tbl_customer_invoice::where('inv_id', $sales_receipt_id)->update($ins);
	        // $invoice_id = 0;

	       /* Transaction Journal */
	        $entry["reference_module"]  = 'sales-receipt';
	        $entry["reference_id"]      = $sales_receipt_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = $tax;
	        $entry["discount"]          = $discount;
	        $entry["ewt"]               = $ewt;

			Tbl_customer_invoice_line::where("invline_inv_id", $sales_receipt_id)->delete();
	        $return = Self::insertline($sales_receipt_id, $insert_item, $entry);
	        $return = $sales_receipt_id;

	        if(CustomerWIS::settings($shop_id) == 0)
			{
		        $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
		        /* UPDATE INVENTORY HERE */
				AccountingTransaction::inventory_consume_update($shop_id, $warehouse_id, 'sales_receipt', $sales_receipt_id); 
				AccountingTransaction::consume_inventory($shop_id, $warehouse_id, $insert_item, 'sales_receipt', $sales_receipt_id, 'Consume upon creating SALES RECEIPT '.$ins['transaction_refnum']);
			}
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item, 'sales_receipt');
		if(!$val)
		{
			$return  = null; 
			$ins['inv_shop_id']                  = $shop_id;  
			$ins['inv_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['inv_customer_email']           = $insert['customer_email'];
	        $ins['inv_customer_billing_address'] = $insert['customer_address'];
	        $ins['inv_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
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

	        $ins['is_sales_receipt']             = 1;
            $ins['inv_payment_applied']		     = $overall_price;
            $ins['inv_is_paid']                  = 1;


	        /* INSERT SAlES RECEIPT HERE */
	        $sales_receipt_id = Tbl_customer_invoice::insertGetId($ins);

	        /* Transaction Journal */
	        $entry["reference_module"]  = 'sales-receipt';
	        $entry["reference_id"]      = $sales_receipt_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = $tax;
	        $entry["discount"]          = $discount;
	        $entry["ewt"]               = $ewt;

	        $return = Self::insertline($sales_receipt_id, $insert_item, $entry);

	        if(CustomerWIS::settings($shop_id) == 0)
			{
				$warehouse_id = Warehouse2::get_current_warehouse($shop_id);
				AccountingTransaction::consume_inventory($shop_id, $warehouse_id, $insert_item, 'sales_receipt', $sales_receipt_id, 'Consume upon creating SALES RECEIPT '.$ins['transaction_refnum']);
			}
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function insertline($sales_receipt_id, $insert_item, $entry)
	{
		$itemline = null;
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

			$itemline[$key]['invline_inv_id'] 			= $sales_receipt_id;
			$itemline[$key]['invline_service_date'] 	= $value['item_servicedate'];
			$itemline[$key]['invline_item_id'] 			= $value['item_id'];
			$itemline[$key]['invline_description'] 		= $value['item_description'];
			$itemline[$key]['invline_um'] 				= $value['item_um'];
			$itemline[$key]['invline_qty'] 				= $value['item_qty'];
			$itemline[$key]['invline_rate'] 			= $value['item_rate'];
			$itemline[$key]['invline_discount'] 		= $discount;
			$itemline[$key]['invline_discount_type'] 	= $discount_type;
			$itemline[$key]['invline_discount_remark'] 	= $value['item_remarks'];
			$itemline[$key]['taxable'] 					= $value['item_taxable'] != null ? $value['item_taxable'] : 0;
			$itemline[$key]['invline_amount'] 			= $value['item_amount'];
			$itemline[$key]['date_created'] 			= Carbon::now();

			$itemline[$key]['invline_refname'] 			= $value['item_refname'];
			$itemline[$key]['invline_refid'] 			= $value['item_refid'];
		}
		if(count($itemline) > 0)
		{
			Tbl_customer_invoice_line::insert($itemline);
			AccountingTransaction::entry_data($entry, $insert_item);
			$return = $sales_receipt_id;
		}

		return $return;
	}
    public static function applied_transaction($shop_id, $transaction_id = 0)
    {
        $applied_transaction = Session::get('applied_transaction_sr');
        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value) 
            {
                $update['est_status'] = 'closed';
                Tbl_customer_estimate::where("est_id", $key)->where('est_shop_id', $shop_id)->update($update);
            }
        }
        Self::insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction);
    }
    public static function insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction = array())
    {
    	$get_transaction = Tbl_customer_invoice::where("inv_shop_id", $shop_id)->where("inv_id", $transaction_id)->first();
    	$transaction_data = null;
    	if($get_transaction)
    	{
    		$transaction_data['transaction_ref_name'] = "sales_receipt";
		 	$transaction_data['transaction_ref_id'] = $transaction_id;
		 	$transaction_data['transaction_list_number'] = $get_transaction->transaction_refnum;
		 	$transaction_data['transaction_date'] = $get_transaction->inv_date;

		 	$attached_transaction_data = null;
		 	if(count($applied_transaction) > 0)
		 	{
			 	foreach ($applied_transaction as $key => $value) 
			 	{
			 		$get_data = Tbl_customer_estimate::where("est_shop_id", $shop_id)->where("est_id", $key)->first();
			 		if($get_data)
			 		{
				 		$attached_transaction_data[$key]['transaction_ref_name'] = "estimate_qoutation";
				 		if($get_data->is_sales_order == 1)
				 		{
				 			$attached_transaction_data[$key]['transaction_ref_name'] = "sales_order";
				 		}
					 	$attached_transaction_data[$key]['transaction_ref_id'] = $key;
					 	$attached_transaction_data[$key]['transaction_list_number'] = $get_data->transaction_refnum;
					 	$attached_transaction_data[$key]['transaction_date'] = $get_data->est_date;
			 		}
			 	}
		 	}
    	}

    	if($transaction_data)
		{
			AccountingTransaction::postTransaction($shop_id, $transaction_data, $attached_transaction_data);
		}
    }
}