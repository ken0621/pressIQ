<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_user;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_write_check_line;
use App\Models\Tbl_write_check;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_vendor;
use App\Models\Tbl_pay_bill_line;
use App\Models\Tbl_bill_item_line;
use DB;
use Session;
use Carbon\Carbon;

class WriteCheck
{
    public static function getShopId()
    {
    	return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
	 public static function postWriteCheck($vendor_info, $wc_info, $wc_other_info, $item_info, $total_info)
    {
    	$insert['wc_shop_id']             = WriteCheck::getShopId();    
    	$insert['wc_cash_account']		  = 0;    
        $insert['wc_vendor_id']           = $vendor_info['wc_vendor_id'];
        $insert['wc_vendor_email']        = $vendor_info['wc_vendor_email'];        
        $insert['wc_mailing_address']     = $vendor_info['wc_mailing_address'];

        $insert['wc_payment_date']        = $wc_info['wc_payment_date'];

        $insert['wc_memo']                = $wc_other_info['wc_memo'];
        $insert['wc_total_amount']        = collect($item_info)->sum('itemline_amount');
        $insert['wc_is_paid']             = 1;
        $insert['wc_applied_payment']     = collect($item_info)->sum('itemline_amount');
        $insert['date_created']           = Carbon::now();
        
        $wc_id = Tbl_write_check::insertGetId($insert);

        $wc_data = AuditTrail::get_table_data("tbl_write_check","wc_id",$wc_id);
        AuditTrail::record_logs("Added","write_check",$wc_id,"",serialize($wc_data));

        WriteCheck::insert_wc_line($wc_id, $item_info);

        return $wc_id;

    }
    public static function insertPotoWc($wc_id = null, $po_data = array())
    {
        if($wc_id != null)
        {
            foreach ($po_data as $key => $value) 
            {
                $up_po["po_is_billed"] = $wc_id;
                Tbl_purchase_order::where("po_id",$value["poline_po_id"])->update($up_po);  
            }            
        }
    }

    public static function update_applied_payment($paybill_id)
    {

    }
    public static function update_check_from_paybill($paybill_id)
    {
        $pb_data = Tbl_pay_bill::where("paybill_id",$paybill_id)->first();
        $pbline_data = Tbl_pay_bill_line::where("pbline_pb_id",$paybill_id)->get();

        if($pb_data)
        {
            $insert['wc_shop_id']             = WriteCheck::getShopId();    
            $insert['wc_cash_account']        = 0;    
            $insert['wc_vendor_id']           = $pb_data->paybill_vendor_id;
            $insert['wc_vendor_email']        = Tbl_vendor::where("vendor_id",$pb_data->paybill_vendor_id)->pluck("vendor_email");        
            $insert['wc_mailing_address']     = "";

            $insert['wc_payment_date']        =  $pb_data->paybill_date;

            $insert['wc_memo']                = $pb_data->paybill_memo;
            $insert['wc_total_amount']        = $pb_data->paybill_total_amount;
            $insert['wc_applied_payment']     = $pb_data->paybill_total_amount;
            $insert['wc_ref_name']            = "paybill";
            $insert['wc_ref_id']              = $pb_data->paybill_id;

            $wc_id = Tbl_write_check::insertGetId($insert);

            $item_info = null;
            foreach ($pbline_data as $key => $value) 
            {
                if($value->pbline_reference_name == "bill")
                {
                    $bill_line_data = Tbl_bill_item_line::where("itemline_bill_id",$value->pbline_reference_id)->get();
                    foreach ($bill_line_data as $key1 => $value1)
                    {
                        $item_info["itemline_item_id"] = $value1->itemline_item_id;
                        $item_info["itemline_ref_name"] = "bill";
                        $item_info["itemline_ref_id"] = $value1->itemline_bill_id;
                        $item_info["itemline_description"] = $value1->itemline_description;
                        $item_info["itemline_um"] = $value1->itemline_um;
                        $item_info["itemline_qty"] = $value1->itemline_qty;
                        $item_info["itemline_rate"] = $value1->itemline_rate;
                        $item_info["itemline_amount"] = $value1->itemline_amount;

                        WriteCheck::insert_bill_wc_line($wc_id, $item_info);
                    }
                }
            }

            $wc_data = AuditTrail::get_table_data("tbl_write_check","wc_id",$wc_id);
            AuditTrail::record_logs("Edited","write_check",$wc_id,"",serialize($wc_data));

        }

    }
    public static function create_check_from_paybill($paybill_id)
    {
        $pb_data = Tbl_pay_bill::where("paybill_id",$paybill_id)->first();
        $pbline_data = Tbl_pay_bill_line::where("pbline_pb_id",$paybill_id)->get();

        if($pb_data)
        {
            $insert['wc_shop_id']             = WriteCheck::getShopId();    
            $insert['wc_cash_account']        = 0;    
            $insert['wc_vendor_id']           = $pb_data->paybill_vendor_id;
            $insert['wc_vendor_email']        = Tbl_vendor::where("vendor_id",$pb_data->paybill_vendor_id)->pluck("vendor_email");        
            $insert['wc_mailing_address']     = "";

            $insert['wc_payment_date']        =  $pb_data->paybill_date;

            $insert['wc_memo']                = $pb_data->paybill_memo;
            $insert['wc_total_amount']        = $pb_data->paybill_total_amount;
            $insert['wc_applied_payment']     = $pb_data->paybill_total_amount;

            $wc_id = Tbl_write_check::insertGetId($insert);

            $item_info = null;
            foreach ($pbline_data as $key => $value) 
            {
                if($value->pbline_reference_name == "bill")
                {
                    $bill_line_data = Tbl_bill_item_line::where("itemline_bill_id",$value->pbline_reference_id)->get();
                    foreach ($bill_line_data as $key1 => $value1)
                    {
                        $item_info["itemline_item_id"] = $value1->itemline_item_id;
                        $item_info["itemline_ref_name"] = "bill";
                        $item_info["itemline_ref_id"] = $value1->itemline_bill_id;
                        $item_info["itemline_description"] = $value1->itemline_description;
                        $item_info["itemline_um"] = $value1->itemline_um;
                        $item_info["itemline_qty"] = $value1->itemline_qty;
                        $item_info["itemline_rate"] = $value1->itemline_rate;
                        $item_info["itemline_amount"] = $value1->itemline_amount;

                        WriteCheck::insert_bill_wc_line($wc_id, $item_info);
                    }
                }
            }

            $wc_data = AuditTrail::get_table_data("tbl_write_check","wc_id",$wc_id);
            AuditTrail::record_logs("Added","write_check",$wc_id,"",serialize($wc_data));

        }
    }
    public static function updateWriteCheck($wc_id, $vendor_info, $wc_info, $wc_other_info, $item_info, $total_info)
    {
        $old = AuditTrail::get_table_data("tbl_write_check","wc_id",$wc_id);

        $update['wc_cash_account']			= 0;    
        $update['wc_vendor_id']           = $vendor_info['wc_vendor_id'];
        $update['wc_vendor_email']        = $vendor_info['wc_vendor_email'];        
        $update['wc_mailing_address']     = $vendor_info['wc_mailing_address'];
        $update['wc_payment_date']        = $wc_info['wc_payment_date'];
        $update['wc_memo']                = $wc_other_info['wc_memo'];
        $update['wc_total_amount']        = collect($item_info)->sum('itemline_amount');

        Tbl_write_check::where("wc_id", $wc_id)->update($update);

        $new = AuditTrail::get_table_data("tbl_write_check","wc_id",$wc_id);
        AuditTrail::record_logs("Edited","write_check",$wc_id,serialize($old),serialize($new));

        Tbl_write_check_line::where("wcline_wc_id", $wc_id)->delete();
        WriteCheck::insert_wc_line($wc_id, $item_info);

        return $wc_id;
    }
    public static function insert_bill_wc_line($wc_id, $item_info)
    {
        if($item_info)
        {
            $insert_line['wcline_wc_id']         = $wc_id;
            $insert_line['wcline_item_id']       = $item_info['itemline_item_id'];
            $insert_line['wcline_ref_name']      = $item_info['itemline_ref_name'] ;
            $insert_line['wcline_ref_id']        = $item_info['itemline_ref_id'] ;
            $insert_line['wcline_description']   = $item_info['itemline_description'];
            $insert_line['wcline_um']            = $item_info['itemline_um'];
            $insert_line['wcline_qty']           = $item_info['itemline_qty'];
            $insert_line['wcline_rate']          = $item_info['itemline_rate'];
            $insert_line['wcline_amount']        = $item_info['itemline_amount'];

            Tbl_write_check_line::insert($insert_line);
        }

    }
    public static function insert_wc_line($wc_id, $item_info)
    {
    	foreach($item_info as $key => $item_line)
        {
            if($item_line)
            {
                $insert_line['wcline_wc_id']         = $wc_id;
                $insert_line['wcline_item_id']       = $item_line['itemline_item_id'];
                $insert_line['wcline_ref_name']      = $item_line['itemline_ref_name'] ;
                $insert_line['wcline_ref_id']        = $item_line['itemline_ref_id'] ;
                $insert_line['wcline_description']   = $item_line['itemline_description'];
                $insert_line['wcline_um']            = $item_line['itemline_um'];
                $insert_line['wcline_qty']           = $item_line['itemline_qty'];
                $insert_line['wcline_rate']		     = $item_line['itemline_rate'];
                $insert_line['wcline_amount']        = $item_line['itemline_amount'];

                Tbl_write_check_line::insert($insert_line);
            }
        }

    }
}
