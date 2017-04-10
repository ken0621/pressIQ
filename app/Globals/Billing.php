<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_bill;
use App\Models\Tbl_bill_po;
use App\Models\Tbl_bill_item_line;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Globals\AuditTrail;
use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * Invoice Module - all customer invoice related module
 *
 * @author Bryan Kier Aradanas
 */

class Billing
{

    public static function getShopId()
    {
    	return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function postBill($vendor_info, $bill_info, $bill_other_info, $item_info, $total_info)
    {
    	$insert['bill_shop_id']             = Billing::getShopId();    
    	$insert['bill_ap_account']			= 0;    
        $insert['bill_vendor_id']           = $vendor_info['bill_vendor_id'];
        $insert['bill_vendor_email']        = $vendor_info['bill_vendor_email'];        
        $insert['bill_mailing_address']     = $vendor_info['bill_mailing_address'];
        $insert['bill_terms_id']            = $bill_info['bill_terms_id'];
        $insert['bill_date']                = $bill_info['bill_date'];
        $insert['bill_due_date']            = $bill_info['bill_due_date'];

        $insert['inventory_only']           = $bill_info['inventory_only'];

        $insert['bill_memo']                = $bill_other_info['bill_memo'];
        $insert['bill_total_amount']        = $total_info['bill_total_amount'];
        $insert['bill_payment_method']      = 0;
        $insert['date_created']             = Carbon::now();
        

        $bill_id = Tbl_bill::insertGetId($insert);

        // $bill_data = AuditTrail::get_table_data("tbl_bill","bill_id",$bill_id);
        // AuditTrail::record_logs("Added","bill",$bill_id,"",serialize($bill_data));

        Billing::insert_bill_line($bill_id, $item_info);

        return $bill_id;

    }
    public static function insertPotoBill($bill_id = null, $_po_id = array())
    {
        if($bill_id != null && $_po_id != null)
        {
            $ins["billed_id"] = $bill_id;
            foreach ($_po_id as $key => $value) 
            {
                if($value != "")
                {
                    $ins["purchase_order_id"] = $value;

                    Tbl_bill_po::insert($ins);

                    $up_po["po_is_billed"] = $bill_id;
                    Tbl_purchase_order::where("po_id",$value)->update($up_po);                    
                }
            }

        }
        
    }
    public static function updateBill($bill_id, $vendor_info, $bill_info, $bill_other_info, $item_info, $total_info)
    {
        $old = AuditTrail::get_table_data("tbl_bill","bill_id",$bill_id);

        $update['bill_ap_account']			= 0;    
        $update['bill_vendor_id']           = $vendor_info['bill_vendor_id'];
        $update['bill_vendor_email']        = $vendor_info['bill_vendor_email'];        
        $update['bill_mailing_address']     = $vendor_info['bill_mailing_address'];
        $update['bill_terms_id']            = $bill_info['bill_terms_id'];
        $update['bill_date']                = $bill_info['bill_date'];
        $update['bill_due_date']            = $bill_info['bill_due_date'];
        $update['bill_memo']                = $bill_other_info['bill_memo'];
        $update['bill_total_amount']        = $total_info['bill_total_amount'];
        $update['bill_payment_method']      = 0;

        Tbl_bill::where("bill_id", $bill_id)->update($update);


        // $new = AuditTrail::get_table_data("tbl_bill","bill_id",$bill_id);
        // AuditTrail::record_logs("Edited","bill",$bill_id,serialize($old),serialize($new));

        Tbl_bill_item_line::where("itemline_bill_id", $bill_id)->delete();
        Billing::insert_bill_line($bill_id, $item_info);

        return $bill_id;
    }
    public static function insert_bill_line($bill_id, $item_info)
    {
        foreach($item_info as $key => $item_line)
        {
            if($item_line)
            {
                // $discount = $item_line['discount'];
                // if(strpos($discount, '%'))
                // {
                //     $discount = substr($discount, 0, strpos($discount, '%')) / 100;
                // }
                $insert_line['itemline_poline_id']     = $item_line['itemline_poline_id'] ;
                $insert_line['itemline_po_id']         = $item_line['itemline_po_id'] ;
                $insert_line['itemline_bill_id']       = $bill_id;
                $insert_line['itemline_item_id']       = $item_line['itemline_item_id'];
                $insert_line['itemline_poline_id']     = 0;
                $insert_line['itemline_po_id']         = 0;
                $insert_line['itemline_description']   = $item_line['itemline_description'];
                $insert_line['itemline_um']            = $item_line['itemline_um'];
                $insert_line['itemline_qty']           = $item_line['itemline_qty'];
                $insert_line['itemline_rate']		   = $item_line['itemline_rate'];
                $insert_line['itemline_amount']        = $item_line['itemline_amount'];

                Tbl_bill_item_line::insert($insert_line);
            }
        }
    }
}