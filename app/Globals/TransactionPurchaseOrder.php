<?php
namespace App\Globals;


use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_shop;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionPurchaseOrder
{
	public static function countTransaction($shop_id)
	{
        return Tbl_requisition_slip::where('shop_id',$shop_id)->where("requisition_slip_status","open")->count();
        
    }

    public static function getClosePO($shop_id, $vendor_id)
    {
        return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed',0)->get();
    }

    public static function getOpenPO($shop_id, $vendor_id)
    {
        return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed', '!=', '0')->get();
    }

    public static function postInsert($shop_id, $insert, $insert_item)
	{
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
            $ins['po_shop_id']         = $shop_id;
            $ins['transaction_refnum'] = $insert['transaction_refnumber'];
            $ins['po_vendor_id']       = $insert['vendor_id'];
            $ins['po_billing_address'] = $insert['vendor_address'];
            $ins['po_vendor_email']    = $insert['vendor_email'];
            $ins['po_terms_id']        = $insert['vendor_terms'];
            $ins['po_date']            = date("Y-m-d", strtotime($insert['transaction_date']));
            $ins['po_due_date']        = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $ins['po_message']         = $insert['vendor_message'];
            $ins['po_memo']            = $insert['vendor_memo'];
            $ins['ewt']                = $insert['vendor_ewt'];
            $ins['po_terms_id']        = $insert['vendor_terms'];
            $ins['po_discount_value']  = $insert['vendor_discount'];
            $ins['po_discount_type']   = $insert['vendor_discounttype'];
            $ins['taxable']            = $insert['vendor_tax'];
            $ins['date_created']       = Carbon::now();

             /* SUBTOTAL */
            $subtotal_price = collect($insert_item)->sum('item_amount'); 

            /* DISCOUNT */
            $discount = $insert['vendor_discount'];
            if($insert['vendor_discounttype'] == 'percent')
            {
                $discount = (convertToNumber($insert['vendor_discount']) / 100) * $subtotal_price;
            }

            /* TAX */
            $tax = (collect($insert_item)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

            /* EWT */
            $ewt = $subtotal_price * convertToNumber($insert['vendor_ewt']);

            /* OVERALL TOTAL */
            $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

            $ins['po_subtotal_price'] = $subtotal_price;
            $ins['po_overall_price']  = $overall_price;

            /* INSERT PO IN DATABASE */
            $purchase_order_id = Tbl_purchase_order::insertGetId($ins);
            $return = $purchase_order_id;
            //$return = Self::insertline($purchase_order_id, $insert_item);
		}
        else
        {
            $return = $val;
        }  
        return $return;
	}

    public static function insertLine($purchase_order_id, $insert_item)
    {
        $return = null;

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
            /*FROM DATABASE*/                        /*FROM CONTROLLER*/
            $itemline[$key]['poline_po_id']          = $purchase_order_id;
            $itemline[$key]['poline_service_date']   = $value['item_servicedate']; 
            $itemline[$key]['poline_item_id']        = $value['item_id'];
            $itemline[$key]['poline_description']    = $value['item_description'];
            $itemline[$key]['poline_um']             = $value['item_um'];
            $itemline[$key]['poline_orig_qty']       = $value['item_qty'];
            $itemline[$key]['poline_rate']           = $value['item_rate'];
            $itemline[$key]['poline_discount']       = $value['item_discount']; 
            $itemline[$key]['poline_discount_remark']= $value['item_remark'];  
            $itemline[$key]['poline_amount']         = $value['item_amount'];   
            $itemline[$key]['taxable']               = $value['item_taxable']; 
            $itemline[$key]['date_created']          = Carbon::now();

        }
        if(count($itemline) > 0)
        {
            /*INSERTING ITEMS TO DATABASE*/
            $return = Tbl_purchase_order_line::insert($itemline);
            
        }

        return $return;
    }
}
