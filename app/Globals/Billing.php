<?php
namespace App\Globals;

use App\Models\Tbl_bill;
use App\Models\Tbl_bill_po;
use App\Models\Tbl_bill_item_line;
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_pay_bill_line;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
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

    public static function count_ap($start_date, $end_date)
    {
         $bill = Tbl_bill::where("bill_shop_id",Billing::getShopId())->whereBetween("date_created",array($start_date,$end_date))->where("bill_is_paid",0)->count();
         return $bill;
    }
    public static function count_paid_bills($start_date, $end_date)
    {
         $bill = Tbl_bill::where("bill_shop_id",Billing::getShopId())->whereBetween("date_created",array($start_date,$end_date))->where("bill_is_paid",1)->count();
         return $bill;
    }
    public static function get_ap_amount($start_date, $end_date)
    {
        $price = 0;
        $bill = Tbl_bill::where("bill_shop_id",Billing::getShopId())
                                ->whereBetween("date_created",array($start_date,$end_date))
                                ->where("bill_is_paid",0)->get();
        if(isset($bill))
        {
            foreach ($bill as $key => $value) 
            {
               $price += $value->bill_total_amount;
            }            
        }

        return $price;
    }
    public static function get_paid_bills_amount($start_date, $end_date)
    {
        $price = 0;
        $bill = Tbl_bill::where("bill_shop_id",Billing::getShopId())
                                ->whereBetween("date_created",array($start_date,$end_date))
                                ->where("bill_is_paid",1)->get();
        if(isset($bill))
        {
            foreach ($bill as $key => $value) 
            {
               $price += $value->bill_total_amount;
            }            
        }

        return $price;
    }
    public static function updateAmountApplied($bill_id)
    {
        $payment_applied = Tbl_bill::appliedPayment(Billing::getShopId())->where("bill_id",$bill_id)->pluck("amount_applied");
        
        $data["bill_applied_payment"] = $payment_applied;
        Tbl_bill::where("bill_id", $bill_id)->update($data);

        Billing::updateIsPaid($bill_id);
    }
     public static function updateIsPaid($bill_id)
    {
        $payment_applied   = Tbl_bill::where("bill_id", $bill_id)->pluck("bill_applied_payment"); 
        $overall_price     = Tbl_bill::where("bill_id", $bill_id)->pluck("bill_total_amount"); 

        if($payment_applied == $overall_price)  $data["bill_is_paid"] = 1;
        else                                    $data["bill_is_paid"] = 0;

        Tbl_bill::where("bill_id", $bill_id)->update($data);
    }
    public static function getShopId()
    {
    	return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
    public static function getAllBillByVendor($vendor_id)
    {
          return  Tbl_bill::appliedPayment(Billing::getShopId())->byVendor(Billing::getShopId(), $vendor_id)->where("bill_is_paid", 0)->get()->toArray();
    }
    public static function getAllBillByVendorWithPaybill($vendor_id, $paybill_id)
    {
        $bill_in_paybill = Tbl_pay_bill_line::select("pbline_reference_id")->where("pbline_reference_name", 'bill')
                            ->where("pbline_pb_id", $paybill_id)->get()->toArray();

        return  Tbl_bill::appliedPayment(Billing::getShopId())->byVendor(Billing::getShopId(), $vendor_id)
                ->payBill($paybill_id, $bill_in_paybill)->orderBy("bill_id")->get()->toArray();
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
        $insert['bill_total_amount']        = collect($item_info)->sum('itemline_amount');
        $insert['bill_payment_method']      = 0;
        $insert['date_created']             = Carbon::now();
        

        $bill_id = Tbl_bill::insertGetId($insert);

        /* Transaction Journal */
        $entry["reference_module"]  = "bill";
        $entry["reference_id"]      = $bill_id;
        $entry["name_id"]           = $vendor_info['bill_vendor_id'];
        $entry["total"]             = collect($item_info)->sum('itemline_amount');
        $entry["vatable"]           = '';
        $entry["discount"]          = '';
        $entry["ewt"]               = '';

        $bill_data = AuditTrail::get_table_data("tbl_bill","bill_id",$bill_id);
        AuditTrail::record_logs("Added","bill",$bill_id,"",serialize($bill_data));

        Billing::insert_bill_line($bill_id, $item_info, $entry);

        return $bill_id;

    }
    public static function insertPotoBill($bill_id = null, $po_data = array())
    {
        if($bill_id != null)
        {
            Tbl_bill_po::where("billed_id",$bill_id)->delete();
            // dd($po_data);
            foreach ($po_data as $key => $value) 
            {
                $chk = Tbl_bill_po::where("billed_id",$bill_id)->where("purchase_order_id",$value["poline_po_id"])->first();
                if($chk == null)
                {
                    $ins["billed_id"] = $bill_id;
                    $ins["purchase_order_id"] = $value["poline_po_id"];
                    
                    Tbl_bill_po::insert($ins);

                    $up_po["po_is_billed"] = $bill_id;
                    Tbl_purchase_order::where("po_id",$value["poline_po_id"])->update($up_po);  
                }
            }            
        }
    }
    public static function updatePotoBill($bill_id = null, $po_id = array())
    {
        if($bill_id != null)
        {
            Tbl_bill_po::where("billed_id",$bill_id)->delete();

            foreach ($po_id as $key => $value) 
            {
                $chk = Tbl_bill_po::where("billed_id",$bill_id)->where("purchase_order_id",$value)->first();
                if($chk == null)
                {
                    if($value)
                    {
                        $ins["billed_id"] = $bill_id;
                        $ins["purchase_order_id"] = $value;
                        
                        Tbl_bill_po::insert($ins);

                        $up_po["po_is_billed"] = $bill_id;
                        Tbl_purchase_order::where("po_id",$value)->update($up_po);                        
                    }
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
        $update['bill_total_amount']        = collect($item_info)->sum('itemline_amount');
        $update['bill_payment_method']      = 0;

        Tbl_bill::where("bill_id", $bill_id)->update($update);

        /* Transaction Journal */
        $entry["reference_module"]  = "bill";
        $entry["reference_id"]      = $bill_id;
        $entry["name_id"]           = $vendor_info['bill_vendor_id'];
        $entry["total"]             = collect($item_info)->sum('itemline_amount');
        $entry["vatable"]           = '';
        $entry["discount"]          = '';
        $entry["ewt"]               = '';

        // $new = AuditTrail::get_table_data("tbl_bill","bill_id",$bill_id);
        // AuditTrail::record_logs("Edited","bill",$bill_id,serialize($old),serialize($new));

        Tbl_bill_item_line::where("itemline_bill_id", $bill_id)->delete();
        Billing::insert_bill_line($bill_id, $item_info, $entry);

        return $bill_id;
    }
    public static function insert_bill_line($bill_id, $item_info, $entry)
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
                // $insert_line['itemline_poline_id']     = $item_line['itemline_poline_id'] ;
                // $insert_line['itemline_po_id']         = $item_line['itemline_po_id'] ;
                $insert_line['itemline_bill_id']       = $bill_id;
                $insert_line['itemline_item_id']       = $item_line['itemline_item_id'];
                $insert_line['itemline_ref_name']      = $item_line['itemline_ref_name'] ;
                $insert_line['itemline_ref_id']        = $item_line['itemline_ref_id'] ;
                $insert_line['itemline_description']   = $item_line['itemline_description'];
                $insert_line['itemline_um']            = $item_line['itemline_um'];
                $insert_line['itemline_qty']           = $item_line['itemline_qty'];
                $insert_line['itemline_rate']		   = $item_line['itemline_rate'];
                $insert_line['itemline_amount']        = $item_line['itemline_amount'];

                Tbl_bill_item_line::insert($insert_line);

                /* TRANSACTION JOURNAL */   
                $entry_data[$key]['item_id']            = $item_line['itemline_item_id'];
                $entry_data[$key]['entry_qty']          = $item_line['itemline_qty'];
                $entry_data[$key]['vatable']            = 0;
                $entry_data[$key]['discount']           = 0;
                $entry_data[$key]['entry_amount']       = $item_line['itemline_amount'];
                $entry_data[$key]['entry_description']  = $item_line['itemline_description'];
            }
        }

        $bill_journal = Accounting::postJournalEntry($entry, $entry_data);
    }
}