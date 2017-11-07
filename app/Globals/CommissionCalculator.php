<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_commission;
use App\Models\Tbl_commission_item;
use App\Models\Tbl_commission_invoice;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_settings;
use App\Models\Tbl_user;

use App\Globals\Invoice;
use App\Globals\Item;

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

		$invoice_id = null;

		/* Loop FOR INSERTING INVOICE */
		$loop_for = Self::get_computation($shop_id, $commission_id)['month_amort']; 
		/** NDP */ 
		for ($i = 0; $i < $loop_for ; $i++) 
		{ 
	        $customer_info['customer_id']       = $comm['customer_id'];
	        $customer_info['customer_email']    = $comm['customer_email'];

	        $invoice_info['invoice_date']       = $comm['date'];
	        $invoice_info['invoice_due']        = $comm['due_date'];
	        $invoice_info['new_inv_id']			= $commission_id.'00'.($i + 1);
	        $invoice_info['billing_address']	= Item::get_item_details($comm_item['item_id'])->item_name;
			$invoice_info['invoice_terms_id']	= 0;

	        $invoice_other_info['invoice_msg']  = "";
	        $invoice_other_info['invoice_memo'] = "";

	        $item_info[0]['item_service_date']  = "";
	        $item_info[0]['item_id']            = $comm_item['item_id'];
	        $item_info[0]['item_description']   = Item::get_item_details($comm_item['item_id'])->item_sales_information;
	        $item_info[0]['discount']   		= 0;
	        $item_info[0]['discount_remark']	= "";
	        $item_info[0]['um']			   		= "";
	        $item_info[0]['taxable']	   		= 0;
	        $item_info[0]['ref_name']	   		= "";
	        $item_info[0]['ref_id']	   			= 0;
	        $item_info[0]['quantity']           = 1;
	        $item_info[0]['rate']               = round(Self::get_computation($shop_id, $commission_id)['amount_monthly_amort'],5);
	        $item_info[0]['amount']             = round(Self::get_computation($shop_id, $commission_id)['amount_monthly_amort'],5);

	        $total_info['ewt']                  = 0;
	        $total_info['total_discount_type']  = 0;
	        $total_info['total_discount_value'] = 0;
	        $total_info['taxable']              = 0;

	        $invoice_id[$i] = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);
		}
		$tcp = $loop_for + 1;
		/** TCP */
		$customer_info['customer_id']       = $comm['customer_id'];
        $customer_info['customer_email']    = $comm['customer_email'];

        $invoice_info['invoice_date']       = $comm['date'];
        $invoice_info['invoice_due']        = $comm['due_date'];
        $invoice_info['new_inv_id']			= $commission_id.'00'.($tcp);
        $invoice_info['billing_address']	= Item::get_item_details($comm_item['item_id'])->item_name;
		$invoice_info['invoice_terms_id']	= 0;

        $invoice_other_info['invoice_msg']  = "";
        $invoice_other_info['invoice_memo'] = "";

        $item_info[0]['item_service_date']  = "";
        $item_info[0]['item_id']            = $comm_item['item_id'];
        $item_info[0]['item_description']   = Item::get_item_details($comm_item['item_id'])->item_sales_information;
        $item_info[0]['discount']   		= 0;
        $item_info[0]['discount_remark']	= "";
        $item_info[0]['um']			   		= "";
        $item_info[0]['taxable']	   		= 0;
        $item_info[0]['ref_name']	   		= "";
        $item_info[0]['ref_id']	   			= 0;
        $item_info[0]['quantity']           = 1;
        $item_info[0]['rate']               = round(Self::get_computation($shop_id, $commission_id)['amount_loanable'],5);
        $item_info[0]['amount']             = round(Self::get_computation($shop_id, $commission_id)['amount_loanable'],5);

        $total_info['ewt']                  = 0;
        $total_info['total_discount_type']  = 0;
        $total_info['total_discount_value'] = 0;
        $total_info['taxable']              = 0;

        $tcp_invoice_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);

        $ins['invoice_id'] = $tcp_invoice_id;
		$ins['commission_id'] = $commission_id;
		$ins['commission_amount'] = round(Self::get_computation($shop_id, $commission_id)['amount_loanable'],5);
		$ins['commission_type'] = 'TCPC';

		Tbl_commission_invoice::insert($ins);

		foreach ($invoice_id as $key => $value) 
		{
			$ins['invoice_id'] = $value;
			$ins['commission_id'] = $commission_id;
			$ins['commission_amount'] = round(Self::get_computation($shop_id, $commission_id)['amount_monthly_commission'],5);
			$ins['commission_type'] = 'NDPC';
			Tbl_commission_invoice::insert($ins);
		}

		// die(var_dump($comm_item_id));
		return "success";
		
	}
	public static function get_computation($shop_id, $commission_id)
	{
		$return['amount_tsp'] = 0;
		$return['percent_dp'] = 0;
		$return['amount_dp'] = 0;
		$return['amount_net_dp'] = 0;
		$return['amount_discount'] = 0;
		$return['month_amort'] = 0;
		$return['amount_monthly_amort'] = 0;
		$return['percent_misc'] = 0;
		$return['amount_misc'] = 0;
		$return['amount_loanable'] = 0;
		$return['amount_tcp'] = 0;
		$return['amount_tc'] = 0;
		$return['percent_ndp_comm'] = 0;
		$return['percent_tcp_comm'] = 0;
		$return['amount_ndp_comm'] = 0;
		$return['amount_tcp_comm'] = 0;
		$return['amount_monthly_commission'] = 0;

		$comm_data = Tbl_commission::where('commission_id',$commission_id)->where('shop_id',$shop_id)->first();
		$comm_item_data = Tbl_commission_item::where('commission_id',$commission_id)->first();

		if($comm_data && $comm_item_data)
		{
			$return['amount_tsp'] = $comm_data->total_selling_price; 
			$return['amount_tcp'] = $comm_data->total_contract_price;
			$return['amount_tc'] = $comm_data->total_commission; 
			$return['amount_loanable'] = $comm_data->loanable_amount;

			$return['percent_dp'] = $comm_item_data->downpayment_percent;
			$return['amount_dp'] = ($comm_item_data->downpayment_percent/100) * $return['amount_tsp'];
			$return['amount_discount'] = $comm_item_data->discount;
			$return['amount_net_dp'] = $return['amount_dp'] - $return['amount_discount'];
			$return['month_amort'] = $comm_item_data->monthly_amort;
			$return['amount_monthly_amort'] = $return['amount_net_dp'] / $comm_item_data->monthly_amort;

			$return['percent_misc'] = $comm_item_data->misceleneous_fee_percent;
			$return['amount_misc'] = ($comm_item_data->misceleneous_fee_percent/100) * $return['amount_tsp'];

			$return['percent_ndp_comm'] = $comm_item_data->ndp_commission;
			$return['percent_tcp_comm'] = $comm_item_data->tcp_commission;

			$return['amount_ndp_comm'] = ($comm_item_data->ndp_commission/100) * $return['amount_tc'];
			$return['amount_tcp_comm'] = ($comm_item_data->tcp_commission/100) * $return['amount_tc'];

			$return['amount_monthly_commission'] = $return['amount_ndp_comm'] / $return['month_amort'];

		}
		// dd($return);

		return $return;
	}
	public static function list($shop_id)
	{
		return Tbl_commission::item()->salesrep()->where('tbl_commission.shop_id',$shop_id)->get();
	}
	public static function check_settings($shop_id)
	{
		return Tbl_settings::where('settings_key','customer_unit_receive_payment')->where('shop_id',$shop_id)->value('settings_value');
	}
	public static function update_commission($invoice_id, $rcvpyment_id)
	{
		$check = Tbl_commission_invoice::where('invoice_id',$invoice_id)->first();
		if($check)
		{
			/*UPDATE COMMISSION HERE*/
			$update['payment_ref_name'] = 'receive_payment';
			$update['payment_ref_id'] = $rcvpyment_id;
			$update['invoice_is_paid'] = 1;
			$update['is_released'] = 1;	
			if(strtolower($check->commission_type) == 'tcpc')
			{
				$update['is_released'] = Self::check_ndp_paid_all($check->commission_id);			
			}
			Tbl_commission_invoice::where('invoice_id',$invoice_id)->update($update);
		}
	}
	public static function check_ndp_paid_all($commission_id)
	{
		$shop_id = Self::getShopId();
		$total_month = Self::get_computation($shop_id, $commission_id)['month_amort']; 
		$total_paid_month = Tbl_commission_invoice::where('commission_id',$commission_id)->where('commission_type','NDPC')->where('invoice_is_paid',1)->count();
		$return = 0;
		if($total_month == $total_paid_month)
		{
			$return = 1;
		}
		return $return;
	}
	public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }
}