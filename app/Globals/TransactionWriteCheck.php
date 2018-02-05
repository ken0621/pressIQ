<?php
namespace App\Globals;
use App\Models\Tbl_write_check_account_line;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_write_check_line;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_write_check;
use App\Models\Tbl_customer;
use App\Models\Tbl_vendor;
use App\Models\Tbl_bill;

use App\Globals\AccountingTransaction;
use Carbon\Carbon;
use Validator;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionWriteCheck
{
	public static function countTransaction($shop_id, $vendor_id)
	{
		return Tbl_bill::where('bill_shop_id',$shop_id)->where('bill_vendor_id', $vendor_id)->where('bill_is_paid', 0)->count();
	}
    public static function info($shop_id, $wc_id)
    {
        return Tbl_write_check::vendor()->customer()->where("wc_shop_id", $shop_id)->where("wc_id", $wc_id)->first();
    }
    public static function info_item($wc_id)
    {
        return Tbl_write_check_line::um()->where("wcline_wc_id", $wc_id)->get();       
    }
    public static function acc_line($wc_id)
    {
        return Tbl_write_check_account_line::where("accline_wc_id", $wc_id)->get();       
    }
	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_write_check::vendor()->customer()->where('wc_shop_id', $shop_id);
		
		if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");

                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");

                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("wc_id", "LIKE", "%$search_keyword%");
                $q->orWhere("wc_total_amount", "LIKE", "%$search_keyword%");
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
	public static function getAllWC($shop_id)
	{
		$data = Tbl_write_check::where("wc_shop_id", $shop_id)->get();
        
        foreach ($data as $key => $value) 
        {
            $v_data = Tbl_vendor::where("vendor_id",$value->wc_reference_id)->first();

            $name = isset($v_data) ? ($v_data->vendor_company != "" ? $v_data->vendor_company : $v_data->vendor_first_name." ".$v_data->vendor_last_name) : "";
            
            if($value->wc_reference_name == "customer")
            {
                $c_data = Tbl_customer::where("customer_id",$value->wc_reference_id)->first();
                
                $name = isset($c_data) ? ($c_data->company != "" ? $c_data->company : $c_data->first_name." ".$c_data->last_name) : "";
            }

            $data[$key]->name = $name;
        }
		
		return $data;
	}

	public static function postInsert($shop_id, $insert, $insert_item, $insert_acct = array())
	{

		$val = Self::writeCheckValidation($insert, $insert_item, $shop_id, $insert_acct, 'write_check');
		if(!$val)
		{
            
			$ins['wc_shop_id']				= $shop_id;
			$ins['transaction_refnum']		= $insert['transaction_refnumber'];
			$ins['wc_reference_id']         = $insert['vendor_id'];
	        $ins['wc_reference_name']       = $insert['wc_reference_name'];
	        $ins['wc_customer_vendor_email']= $insert['vendor_email'];
	        $ins['wc_mailing_address']      = $insert['wc_mailing_address'];
	        $ins['wc_cash_account']         = 0;
	        $ins['wc_payment_date']         = date('Y-m-d', strtotime($insert['wc_payment_date']));
	        $ins['wc_memo']                 = $insert['wc_memo'];
	        $ins['date_created']            = Carbon::now();

	        /*TOTAL*/
	        $total = collect($insert_item)->sum('item_amount');
            $total_acct = collect($insert_acct)->sum('account_amount');
	        $ins['wc_total_amount'] = $total + $total_acct;
	       
	        /*INSERT CV HERE*/
	        $write_check_id = Tbl_write_check::insertGetId($ins);

	        /* Transaction Journal */
	        $entry["reference_module"]  = "write-check";
	        $entry["reference_id"]      = $write_check_id;
	        $entry["name_id"]           = $insert['vendor_id'];
	        $entry["name_reference"]    = $insert['wc_reference_name'];
	        $entry["total"]             = $ins['wc_total_amount'];
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

	        $return = Self::insertLine($write_check_id, $insert_item, $entry, $insert_acct);
	        $return = $write_check_id;

            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id, 'Refill upon creating WRITE CHECK '.$ins['transaction_refnum']);
		}
		else
		{
			$return = $val;
		}

        return $return;
	}
    public static function postUpdate($write_check_id, $shop_id, $insert, $insert_item, $insert_acct = array())
    {
        $val = Self::writeCheckValidation($insert, $insert_item, $shop_id, $insert_acct);
        if(!$val)
        {
            $ins['wc_shop_id']              = $shop_id;
            $ins['transaction_refnum']      = $insert['transaction_refnumber'];
            $ins['wc_reference_id']         = $insert['vendor_id'];
            $ins['wc_reference_name']       = $insert['wc_reference_name'];
            $ins['wc_customer_vendor_email']= $insert['vendor_email'];
            $ins['wc_mailing_address']      = $insert['wc_mailing_address'];
            $ins['wc_cash_account']         = 0;
            $ins['wc_payment_date']         = date('Y-m-d', strtotime($insert['wc_payment_date']));
            $ins['wc_memo']                 = $insert['wc_memo'];
            $ins['date_created']            = Carbon::now();

            /*TOTAL*/
            $total = collect($insert_item)->sum('item_amount');
            $total_acct = collect($insert_acct)->sum('account_amount');
            $ins['wc_total_amount'] = $total + $total_acct;
           
            /*INSERT CV HERE*/
            Tbl_write_check::where('wc_id', $write_check_id)->update($ins);

            /* Transaction Journal */
            $entry["reference_module"]  = "write-check";
            $entry["reference_id"]      = $write_check_id;
            $entry["name_id"]           = $insert['vendor_id'];
            //$entry["name_reference"]    = $insert['wc_reference_name'];
            $entry["total"]             = $ins['wc_total_amount'];
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';

            Tbl_write_check_line::where('wcline_wc_id', $write_check_id)->delete();
            Tbl_write_check_account_line::where('accline_wc_id', $write_check_id)->delete();

            $return = Self::insertLine($write_check_id, $insert_item, $entry, $insert_acct);
            $return = $write_check_id;

            
            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            /* UPDATE INVENTORY HERE */
            AccountingTransaction::inventory_refill_update($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id); 
            AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id, 'Refill upon creating WRITE CHECK '.$ins['transaction_refnum']);
        }
        else
        {
            $return = $val;
        }

        return $return;
    }
	public static function insertLine($write_check_id, $insert_item, $entry, $insert_acct = array())
    {
        $return = null;
        if(count($insert_acct) > 0)
        {
            $acct_line = null;
            foreach ($insert_acct as $key_acct => $value_acct)
            {
                if($value_acct)
                {
                    $acct_line[$key_acct]['accline_wc_id']       = $write_check_id;
                    $acct_line[$key_acct]['accline_coa_id']      = $value_acct['account_id'];
                    $acct_line[$key_acct]['accline_description'] = $value_acct['account_desc'];
                    $acct_line[$key_acct]['accline_amount']      = $value_acct['account_amount'];

                    $entry_data['a'.$key_acct]['account_id']        = $value_acct['account_id'];
                    $entry_data['a'.$key_acct]['entry_description'] = $value_acct['account_desc'];
                    $entry_data['a'.$key_acct]['entry_amount']      = $value_acct['account_amount'];
                    $entry_data['a'.$key_acct]['vatable']           = 0;
                    $entry_data['a'.$key_acct]['discount']          = 0;
                }
            } 

            Tbl_write_check_account_line::insert($acct_line); 
        }

        $itemline = null;
        if(count($insert_item) > 0)
        {
            foreach ($insert_item as $key => $value) 
            {   
                //die(var_dump($value['item_ref_id']));
                $itemline[$key]['wcline_wc_id']       = $write_check_id;
                $itemline[$key]['wcline_item_id']     = $value['item_id'];
                $itemline[$key]['wcline_ref_id']      = $value['item_ref_id'] != NULL ? $value['item_ref_id'] : 0;
                $itemline[$key]['wcline_ref_name']    = $value['item_ref_name'] != NULL ? $value['item_ref_name'] : '';
                $itemline[$key]['wcline_description'] = $value['item_description'];
                $itemline[$key]['wcline_um']          = $value['item_um'];
                $itemline[$key]['wcline_qty']         = $value['item_qty'];
                $itemline[$key]['wcline_rate']        = $value['item_rate'];
                $itemline[$key]['wcline_amount']      = $value['item_amount'];
           
                $item_type = Item::get_item_type($value['item_id']);
                /* TRANSACTION JOURNAL */  
                if($item_type != 4 && $item_type != 5)
                {
                    $entry_data[$key]['item_id']            = $value['item_id'];
                    $entry_data[$key]['entry_qty']          = $value['item_qty'];
                    $entry_data[$key]['vatable']            = 0;
                    $entry_data[$key]['discount']           = 0;
                    $entry_data[$key]['entry_amount']       = $value['item_amount'];
                    $entry_data[$key]['entry_description']  = $value['item_description'];
                                       
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
                            $entry_data['b'.$key.$key_bundle]['entry_qty']          = $value['item_qty'] * (UnitMeasurement::um_qty($value_bundle->bundle_um_id) * $value_bundle->bundle_qty);
                            $entry_data['b'.$key.$key_bundle]['vatable']            = 0;
                            $entry_data['b'.$key.$key_bundle]['discount']           = 0;
                            $entry_data['b'.$key.$key_bundle]['entry_amount']       = $item_data->item_price * $entry_data['b'.$key.$key_bundle]['entry_qty'];
                            $entry_data['b'.$key.$key_bundle]['entry_description']  = $item_data->item_sales_information; 
                        }
                    }
                }

            }
            
            Tbl_write_check_line::insert($itemline);
        }

        

        if(count($entry_data) > 0)
        {
            Accounting::postJournalEntry($entry, $entry_data);        
        }


        $return = $write_check_id;

        return $return;
    }
    public static function checkPoQty($wc_id = null, $po_data = array())
    {
        if($wc_id != null)
        {
            if(count($po_data) > 0)
            {
                foreach ($po_data as $key => $value)
                { 
                    Self::checkPolineQty($key, $wc_id);
                }   
            }
        }
    }
    public static function checkPolineQty($po_id, $wc_id)
    {
        $poline = Tbl_purchase_order_line::where('poline_po_id', $po_id)->get();

        $ctr = 0;
        foreach ($poline as $key => $value)
        {
            $wcline = Tbl_write_check_line::where('wcline_wc_id', $wc_id)->where('wcline_item_id', $value->poline_item_id)->where('wcline_ref_name', 'purchase_order')->where('wcline_ref_id',$po_id)->first();
            
            $update['poline_qty'] = $value->poline_qty - $wcline->wcline_qty;       
            Tbl_purchase_order_line::where('poline_id', $value->poline_id)->update($update);    

            if($update['poline_qty'] <= 0)
            {
                $ctr++;
            }
        }
        if($ctr >= count($poline))
        {
            $updates["po_is_billed"] = $wc_id;
            Tbl_purchase_order::where("po_id",$po_id)->update($updates);
        }
    }
    public static function writeCheckValidation($insert, $insert_item, $shop_id, $insert_acct, $transaction_type = '')
    {
        $return = null;
        if(!$insert['vendor_id'])
        {
            $return .= '<li style="list-style:none">Please Select Vendor.</li>';          
        }
        if(count($insert_acct) <= 0 && count($insert_item) <= 0)
        {
            $return .= '<li style="list-style:none">Please Select Item or Account.</li>';          
        }
        if($transaction_type)
        {
            $return .= AccountingTransaction::check_transaction_ref_number($shop_id, $insert['transaction_refnumber'], $transaction_type);
        }


        $rules['transaction_refnumber'] = 'required';
        $rules['vendor_email']          = 'email';

        $validator = Validator::make($insert, $rules);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li><br>') as $keys => $message)
            {
                $return .= $message;
            }
        }
        return $return;
    }

}