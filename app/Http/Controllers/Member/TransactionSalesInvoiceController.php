<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Transaction;
use App\Globals\UnitMeasurement;
use App\Globals\TransactionSalesInvoice;
use App\Globals\TransactionSalesOrder;
use App\Globals\TransactionEstimateQuotation;

use App\Globals\AccountingTransaction;
use App\Globals\CustomerWIS;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionSalesInvoiceController extends Member
{
  	public function getIndex()
	{
		$data['page'] = "Sales Invoice";
		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice_list',$data);
	}
	public function getLoadSalesInvoice(Request $request)
	{
		$data['_sales_invoice'] = TransactionSalesInvoice::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice_table',$data);		
	}
	public function getCreate(Request $request)
	{
		$data['page'] = "Create Sales Invoice";		
        $data["transaction_refnum"]  = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'sales_invoice');
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["_terms"]     = Customer::getTerms($this->user_info->shop_id,0);
        $data['action']		= "/member/transaction/sales_invoice/create-sales-invoice";
        if($request->id)
        {
        	$data['action']		= "/member/transaction/sales_invoice/update-sales-invoice";
        	$data['sales_invoice'] = TransactionSalesInvoice::info($this->user_info->shop_id, $request->id);
        	$data['sales_invoice_item'] = TransactionSalesInvoice::info_item($request->id);
        }

        Session::forget('applied_transaction_si');

		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice',$data);
	}
	public function postCreateSalesInvoice(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_billing_address;
		$insert['transaction_date']      = date("Y-m-d", strtotime($request->transaction_date));
		$insert['transaction_duedate']   = date("Y-m-d", strtotime($request->transaction_duedate));
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
		$insert['customer_ewt']          = $request->customer_ewt;
		$insert['customer_terms']        = $request->customer_terms;
		$insert['customer_discount']     = $request->customer_discount;
		$insert['customer_discounttype'] = $request->customer_discounttype;
		$insert['customer_tax'] 		 = $request->customer_tax;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] 		   	= $value;
				$insert_item[$key]['item_servicedate'] 	= date("Y-m-d", strtotime($request->item_servicedate[$key]));
				$insert_item[$key]['item_description'] 	= $request->item_description[$key];
				$insert_item[$key]['item_um'] 			= $request->item_um[$key];
				$insert_item[$key]['item_qty'] 			= str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] 		= str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_discount'] 	= str_replace(',', '', $request->item_discount[$key]);
				$insert_item[$key]['item_remarks'] 		= $request->item_remarks[$key];
				$insert_item[$key]['item_amount'] 		= str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] 		= isset($request->item_taxable[$key]) ? $request->item_taxable[$key] : 0;
			}
		}

		$return = null;
		$validate = null;
		if(CustomerWIS::settings($this->user_info->shop_id) == 0)
		{
			$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
			$validate = AccountingTransaction::inventory_validation('consume', $this->user_info->shop_id, $warehouse_id, $insert_item);
		}
		if(!$validate)
		{
			$return = null;
			$validate = TransactionSalesInvoice::postInsert($this->user_info->shop_id, $insert, $insert_item);
			TransactionSalesInvoice::applied_transaction($this->user_info->shop_id);
		}
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success creating invoice.';
			$return['call_function'] = 'success_invoice';
			$return['status_redirect'] = AccountingTransaction::get_redirect('sales_invoice', $validate ,$btn_action);
			Session::forget('applied_transaction_si');
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}

	public function postUpdateSalesInvoice(Request $request)
	{
		$btn_action = $request->button_action;
		$invoice_id = $request->invoice_id;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_billing_address;
		$insert['transaction_date']      = date("Y-m-d", strtotime($request->transaction_date));
		$insert['transaction_duedate']   = date("Y-m-d", strtotime($request->transaction_duedate));
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
		$insert['customer_ewt']          = $request->customer_ewt;
		$insert['customer_terms']        = $request->customer_terms;
		$insert['customer_discount']     = $request->customer_discount;
		$insert['customer_discounttype'] = $request->customer_discounttype;
		$insert['customer_tax'] 		 = $request->customer_tax;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] 		   	= $value;
				$insert_item[$key]['item_servicedate'] 	= date("Y-m-d", strtotime($request->item_servicedate[$key]));
				$insert_item[$key]['item_description'] 	= $request->item_description[$key];
				$insert_item[$key]['item_um'] 			= $request->item_um[$key];
				$insert_item[$key]['item_qty'] 			= str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] 		= str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_discount'] 	= str_replace(',', '', $request->item_discount[$key]);
				$insert_item[$key]['item_remarks'] 		= $request->item_remarks[$key];
				$insert_item[$key]['item_amount'] 		= str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] 		= isset($request->item_taxable[$key]) ? $request->item_taxable[$key] : 0;
			}
		}
		$return = null;

		$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
		$validate = null;
		if(CustomerWIS::settings($shop_id) == 0)
		{
			$validate = AccountingTransaction::inventory_validation('consume', $this->user_info->shop_id, $warehouse_id, $insert_item);
		}
		if(!$validate)
		{
			$return = null;
			$validate = TransactionSalesInvoice::postUpdate($invoice_id, $this->user_info->shop_id, $insert, $insert_item);
			TransactionSalesInvoice::applied_transaction($this->user_info->shop_id);
		}
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success updating invoice.';
			$return['call_function'] = 'success_invoice';
			$return['status_redirect'] = AccountingTransaction::get_redirect('sales_invoice', $validate ,$btn_action);
			Session::forget('applied_transaction_si');
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}
	public function getCountTransaction(Request $request)
	{
		$customer_id = $request->customer_id;
		return TransactionSalesInvoice::CountTransaction($this->user_info->shop_id, $customer_id);
	}
	public function getLoadTransaction(Request $request)
	{
		$data['_eq'] = TransactionEstimateQuotation::getOpenEQ($this->user_info->shop_id, $request->c);
		$data['_so'] = TransactionSalesOrder::getOpenSO($this->user_info->shop_id, $request->c);
		$data['customer_name'] = Customer::get_name($this->user_info->shop_id, $request->c);
		$data['action'] = '/member/transaction/sales_invoice/apply-transaction';

        $data['applied'] = Session::get('applied_transaction_si');
		return view("member.accounting_transaction.customer.sales_invoice.load_transaction", $data);
	}

    public function postApplyTransaction(Request $request)
    {
        $_transaction = $request->apply_transaction;
        Session::put('applied_transaction_si', $_transaction);

        $return['call_function'] = "success_apply_transaction";
        $return['status'] = "success";

        return json_encode($return);
    }
     public function getLoadAppliedTransaction(Request $request)
    {
        $_ids = Session::get('applied_transaction_si');

        $return = null;
        $remarks = null;
        if(count($_ids) > 0)
        {
            foreach ($_ids as $key => $value) 
            {
                $get = TransactionSalesInvoice::transaction_data_item($key);
                $info = TransactionSalesInvoice::transaction_data($this->user_info->shop_id, $key);

                foreach ($get as $key_item => $value_item)
                {
                    $return[$key.'i'.$key_item]['service_date'] = $value_item->estline_service_date;
                    $return[$key.'i'.$key_item]['item_id'] = $value_item->estline_item_id;
                    $return[$key.'i'.$key_item]['item_description'] = $value_item->estline_description;
                    $return[$key.'i'.$key_item]['multi_um_id'] = $value_item->multi_um_id;
                    $return[$key.'i'.$key_item]['item_um'] = $value_item->estline_um;
                    $return[$key.'i'.$key_item]['item_qty'] = $value_item->estline_qty;
                    $return[$key.'i'.$key_item]['item_rate'] = $value_item->estline_rate;
                    $return[$key.'i'.$key_item]['item_amount'] = $value_item->estline_amount;
                    $return[$key.'i'.$key_item]['item_discount'] = $value_item->estline_discount;
                    $return[$key.'i'.$key_item]['item_discount_type'] = $value_item->estline_discount_type;
                    $return[$key.'i'.$key_item]['item_remarks'] = $value_item->estline_discount_remark;
                    $return[$key.'i'.$key_item]['taxable'] = $value_item->taxable;
                }
                if($info)
                {
                	$con = 'SO#';
                	if($info->is_sales_order == 0)
                	{
                		$con = 'EQ#';
                	}
                    $remarks .= $info->transaction_refnum != "" ? $info->transaction_refnum.', ' : $con.$info->est_id.', ';
                }
            }
        }
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data['_transactions'] = $return;
        $data['remarks'] = $remarks;
        $data['_um']        = UnitMeasurement::load_um_multi();

        return view('member.accounting_transaction.customer.sales_invoice.applied_transaction', $data);
    }
	public function getPrint(Request $request)
	{
		dd("Under Maintenance");
	}
}