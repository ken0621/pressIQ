<?php
namespace App\Globals;

use App\Models\Tbl_receive_inventory_line;
use App\Models\Tbl_receive_inventory;
use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_shop;
use App\Models\Tbl_bill_po;
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
    public static function countOpenPOTransaction($shop_id, $vendor_id)
    {
        return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed', 0)->count();
    }
    public static function info($shop_id, $po_id)
    {
        return Tbl_purchase_order::vendor()->where("po_shop_id", $shop_id)->where("po_id", $po_id)->first();
    }
    public static function info_item($po_id)
    {
        return Tbl_purchase_order_line::um()->item()->where("poline_po_id", $po_id)->get();        
    }
    public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
    {
        $data = Tbl_purchase_order::Vendor()->where('po_shop_id',$shop_id);

        if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("po_id", "LIKE", "%$search_keyword%");
                $q->orWhere("po_overall_price", "LIKE", "%$search_keyword%");
            });
        }
        if($status != 'all')
        {
            if($status == 'open')
            {
                $data->where('po_is_billed', 0);
            
            }
            if($status == 'closed')
            {
                $data->where('po_is_billed',"!=",'0');
            }            
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

    public static function getClosePO($shop_id, $vendor_id)
    {
        return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed','!=', '0')->get();
    }

    public static function getOpenPO($shop_id, $vendor_id)
    {
        $data = Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed', 0)->get();

        foreach ($data as $key => $value)
        {
            $data[$key]->po_balance = Self::getPOBalance($shop_id, $vendor_id, $value->po_id);
        }
        return $data;
    }
    public static function getPOBalance($shop_id, $vendor_id, $po_id)
    {        
        $data = Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed', 0)->where('po_id', $po_id)->first();
        $po_line = Tbl_purchase_order_line::where('poline_po_id', $data->po_id)->get();
        
        $poline_amount = null;
        foreach ($po_line as $key => $value)
        {
            $balance = $value->poline_qty * $value->poline_rate;
            $poline_amount += $balance;
        }

        return $poline_amount;
    }
    public static function postInsert($shop_id, $insert, $insert_item)
	{
        $val = AccountingTransaction::vendorValidation($insert, $insert_item, 'purchase_order');
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
            //die(var_dump($overall_price));

            $ins['po_subtotal_price'] = $subtotal_price;
            $ins['po_overall_price']  = $overall_price;

            /* INSERT PO IN DATABASE */
            $purchase_order_id = Tbl_purchase_order::insertGetId($ins);
        
            $return = Self::insertline($purchase_order_id, $insert_item);

            $return = $purchase_order_id;
		}
        else
        {
            $return = $val;
        }  

        return $return;
	}
    public static function postUpdate($po_id, $shop_id, $insert, $insert_item)
    {
        $old = Tbl_purchase_order::where("po_id", $po_id);

        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
            $update['po_shop_id']         = $shop_id;
            $update['transaction_refnum'] = $insert['transaction_refnumber'];
            $update['po_vendor_id']       = $insert['vendor_id'];
            $update['po_billing_address'] = $insert['vendor_address'];
            $update['po_vendor_email']    = $insert['vendor_email'];
            $update['po_terms_id']        = $insert['vendor_terms'];
            $update['po_date']            = date("Y-m-d", strtotime($insert['transaction_date']));
            $update['po_due_date']        = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $update['po_message']         = $insert['vendor_message'];
            $update['po_memo']            = $insert['vendor_memo'];
            $update['ewt']                = $insert['vendor_ewt'];
            $update['po_terms_id']        = $insert['vendor_terms'];
            $update['po_discount_value']  = $insert['vendor_discount'];
            $update['po_discount_type']   = $insert['vendor_discounttype'];
            $update['taxable']            = $insert['vendor_tax'];
            $update['date_created']       = Carbon::now();
            
            //die(var_dump($insert['vendor_ewt']));
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
            //die(var_dump($overall_price));
            
            $update['po_subtotal_price'] = $subtotal_price;
            $update['po_overall_price']  = $overall_price;

            /*UPDATE PO IN DATABASE */
            Tbl_purchase_order::where("po_id", $po_id)->update($update);
        
            Tbl_purchase_order_line::where("poline_po_id", $po_id)->delete();
            Self::insertLine($po_id, $insert_item);

            $return = $po_id;
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
            $itemline[$key]['poline_qty']            = $value['item_qty'];
            $itemline[$key]['poline_rate']           = $value['item_rate'];
            $itemline[$key]['poline_discount']       = $discount;
            $itemline[$key]['poline_discounttype']   = $discount_type;
            $itemline[$key]['poline_discount_remark']= $value['item_remark'];  
            $itemline[$key]['poline_amount']         = $value['item_amount'];   
            $itemline[$key]['taxable']               = $value['item_taxable'];
            $itemline[$key]['poline_refname']        = $value['item_ref_name'];   
            $itemline[$key]['poline_refid']          = $value['item_ref_id']; 
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
