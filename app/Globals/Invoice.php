<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_receive_payment_line;
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

class Invoice
{
    public static function count_ar()
    {
         $ar = Tbl_customer_invoice::where("inv_shop_id",Invoice::getShopId())->where("inv_is_paid",0)->count();
         return $ar;
    }
    public static function get_ar_amount()
    {
        $price = 0;
        $ar = Tbl_customer_invoice::where("inv_shop_id",Invoice::getShopId())->where("inv_is_paid",0)->get();
        if(isset($ar))
        {
            foreach ($ar as $key => $value) 
            {
               $price += $value->inv_overall_price;
            }            
        }

        return $price;
    }
    public static function get_sales_amount()
    {
        $price = 0;
        $ar = Tbl_customer_invoice::where("inv_shop_id",Invoice::getShopId())->where("inv_is_paid",1)->get();
        if(isset($ar))
        {
            foreach ($ar as $key => $value) 
            {
               $price += $value->inv_overall_price;
            }            
        }

        return $price;
    }
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

	/**
	 * Creating a New Customer Invoice
	 *
	 * @param array  $customer_info 		(customer_id => '', customer_email => '' )
	 * @param array  $invoice_info  		(invoice_terms => '', invoice_date => '', invoice_due => '', billing_address => '')
	 * @param array  $invoice_other_info    (invoice_msg => '', invoice_memo => '')
	 * @param array  $item_info   	        ([0]item_service_date => '', [0]item_id => '', [0]item_description => '', [0]quantity => '', 
	 *										 [0]rate => '', [0]discount => '', [0]discount_remark => '', [0]amount => '')
	 * @param array  $total_info   	       (total_item_price => '', total_addons => [[0]label => '', [0]value => ''], 
	 *										 total_discount_type => '', total_discount_value => '', total_overall_price => '')
	 */
	public static function postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info)
	{
        /* DISCOUNT */
        $discount = $total_info['total_discount_value'];
        if($total_info['total_discount_type'] == 'percent') $discount = convertToNumber($total_info['total_discount_value']) / 100;

        /* SUBTOTAL */
        $subtotal_price = collect($item_info)->sum('amount');

        /* TAX */
        $tax = collect($item_info)->where('taxable', '1')->sum('amount');

        /* OVERALL TOTAL */
        $overall_price  = convertToNumber($subtotal_price) - convertToNumber($total_info['ewt']) - ($discount * $subtotal_price) + $tax;

        $insert['inv_shop_id']                  = Invoice::getShopId();  
		$insert['inv_customer_id']              = $customer_info['customer_id'];        
        $insert['inv_customer_email']           = $customer_info['customer_email'];
        $insert['new_inv_id']                   = $invoice_info['new_inv_id'];
        $insert['inv_customer_billing_address'] = $invoice_info['billing_address'];
        $insert['inv_terms_id']                 = $invoice_info['invoice_terms_id'];
        $insert['inv_date']                     = date("Y-m-d", strtotime($invoice_info['invoice_date']));
        $insert['inv_due_date']                 = date("Y-m-d", strtotime($invoice_info['invoice_due']));
        $insert['inv_subtotal_price']           = $subtotal_price;
        $insert['ewt']                          = $total_info['ewt'];
        $insert['inv_discount_type']            = $total_info['total_discount_type'];
        $insert['inv_discount_value']           = $total_info['total_discount_value'];
        $insert['taxable']                      = $total_info['taxable'];
        $insert['inv_overall_price']            = $overall_price;
        $insert['inv_message']                  = $invoice_other_info['invoice_msg'];
        $insert['inv_memo']                     = $invoice_other_info['invoice_memo'];
        $insert['date_created']                 = Carbon::now();     

        $invoice_id = Tbl_customer_invoice::insertGetId($insert);

        Invoice::insert_invoice_line($invoice_id, $item_info);

        $inv_data = AuditTrail::get_table_data("tbl_customer_invoice","inv_id",$invoice_id);
        AuditTrail::record_logs("Added","invoice",$invoice_id,"",serialize($inv_data));

        return $invoice_id;
	}

    public static function updateInvoice($invoice_id, $customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info)
    {        
        $old = AuditTrail::get_table_data("tbl_customer_invoice","inv_id",$invoice_id);

        /* DISCOUNT */
        $discount = $total_info['total_discount_value'];
        if($total_info['total_discount_type'] == 'percent') $discount = convertToNumber($total_info['total_discount_value']) / 100;

        /* SUBTOTAL */
        $subtotal_price = collect($item_info)->sum('amount');

        /* TAX */
        $tax = collect($item_info)->where('taxable', '1')->sum('amount');

        /* OVERALL TOTAL */
        $overall_price  = convertToNumber($subtotal_price) - convertToNumber($total_info['ewt']) - ($discount * $subtotal_price) + $tax;
        
        $update['inv_customer_id']              = $customer_info['customer_id'];        
        $update['inv_customer_email']           = $customer_info['customer_email'];
        $update['new_inv_id']                   = $invoice_info['new_inv_id'];
        $update['inv_customer_billing_address'] = $invoice_info['billing_address'];
        $update['inv_terms_id']                 = $invoice_info['invoice_terms_id'];
        $update['inv_date']                     = date("Y-m-d", strtotime($invoice_info['invoice_date']));
        $update['inv_due_date']                 = date("Y-m-d", strtotime($invoice_info['invoice_due']));
        $update['inv_subtotal_price']           = $subtotal_price;
        $update['ewt']                          = $total_info['ewt'];
        $update['inv_discount_type']            = $total_info['total_discount_type'];
        $update['inv_discount_value']           = $total_info['total_discount_value'];
        $update['taxable']                      = $total_info['taxable'];
        $update['inv_overall_price']            = $overall_price;
        $update['inv_message']                  = $invoice_other_info['invoice_msg'];
        $update['inv_memo']                     = $invoice_other_info['invoice_memo'];   

        Tbl_customer_invoice::where("inv_id", $invoice_id)->update($update);


        $new = AuditTrail::get_table_data("tbl_customer_invoice","inv_id",$invoice_id);
        AuditTrail::record_logs("Edited","invoice",$invoice_id,serialize($old),serialize($new));

        Tbl_customer_invoice_line::where("invline_inv_id", $invoice_id)->delete();
        Invoice::insert_invoice_line($invoice_id, $item_info);

        return $invoice_id;
    }

    public static function insert_invoice_line($invoice_id, $item_info)
    {        
        foreach($item_info as $key => $item_line)
        {
            if($item_line)
            {
                /* DISCOUNT PER LINE */
                $discount       = $item_line['discount'];
                $discount_type  = 'fixed';
                if(strpos($discount, '%'))
                {   
                    $discount       = substr($discount, 0, strpos($discount, '%')) / 100;
                    $discount_type  = 'percent';
                }

                /* AMOUNT PER LINE */
                $amount = (convertToNumber($item_line['rate']) * convertToNumber($item_line['quantity'])) - $discount;

                $insert_line['invline_inv_id']          = $invoice_id;
                $insert_line['invline_service_date']    = date("Y-m-d", strtotime($item_line['item_service_date']));
                $insert_line['invline_item_id']         = $item_line['item_id'];
                $insert_line['invline_description']     = $item_line['item_description'];
                $insert_line['invline_um']              = $item_line['um'];
                $insert_line['invline_qty']             = convertToNumber($item_line['quantity']);
                $insert_line['invline_rate']            = convertToNumber($item_line['rate']);
                $insert_line['invline_discount']        = $item_line['discount'];
                $insert_line['invline_discount_type']   = $discount_type;
                $insert_line['invline_discount_remark'] = $item_line['discount_remark'];
                $insert_line['taxable']                 = $item_line['taxable'];
                $insert_line['invline_amount']          = $amount;
                $insert_line['date_created']            = Carbon::now();

                Tbl_customer_invoice_line::insert($insert_line);
            }
        }

        return $insert_line;
    }

    public static function getAllInvoiceByCustomer($customer_id)
    {
        return  Tbl_customer_invoice::appliedPayment(Invoice::getShopId())->byCustomer(Invoice::getShopId(), $customer_id)->where("inv_is_paid", 0)->get()->toArray();
    }

    public static function getAllInvoiceByCustomerWithRcvPymnt($customer_id, $rcvpayment_id)
    {
        $inv_in_rcvpayment = Tbl_receive_payment_line::select("rpline_reference_id")->where("rpline_reference_name", 'invoice')
                            ->where("rpline_rp_id", $rcvpayment_id)->get()->toArray();

        return  Tbl_customer_invoice::appliedPayment(Invoice::getShopId())->byCustomer(Invoice::getShopId(), $customer_id)
                ->rcvPayment($rcvpayment_id, $inv_in_rcvpayment)->orderBy("inv_id")->get()->toArray();
    }

    public static function updateAmountApplied($inv_id)
    {
        $payment_applied = Tbl_customer_invoice::appliedPayment(Invoice::getShopId())->where("inv_id",$inv_id)->pluck("amount_applied");
        
        $data["inv_payment_applied"] = $payment_applied;
        Tbl_customer_invoice::where("inv_id", $inv_id)->update($data);

        Invoice::updateIsPaid($inv_id);
    }

    public static function updateIsPaid($inv_id)
    {
        $payment_applied   = Tbl_customer_invoice::where("inv_id", $inv_id)->pluck("inv_payment_applied"); 
        $overall_price     = Tbl_customer_invoice::where("inv_id", $inv_id)->pluck("inv_overall_price"); 

        if($payment_applied == $overall_price)  $data["inv_is_paid"] = 1;
        else                                    $data["inv_is_paid"] = 0;

        Tbl_customer_invoice::where("inv_id", $inv_id)->update($data);
    }
  
}
