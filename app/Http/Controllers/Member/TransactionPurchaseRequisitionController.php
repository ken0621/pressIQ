<?php

namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;

use Redirect;

use App\Globals\Warehouse2;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Globals\Vendor;
use App\Globals\Pdf_global;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\CustomerWIS;
use App\Globals\WarehouseTransfer;
use App\Globals\TransactionPurchaseRequisition;

use App\Globals\TransactionSalesOrder;
use App\Globals\TransactionSalesInvoice;
use App\Globals\TransactionEstimateQuotation;
use App\Globals\AccountingTransaction;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use App\Globals\Item;
use App\Globals\AuditTrail;
use App\Globals\RequisitionSlip;
use Validator;
use Excel;
use DB;
class TransactionPurchaseRequisitionController extends Member
{
	public function getIndex()
	{
		$data['page'] = 'Purchase Requisition';
		$data['_list'] = RequisitionSlip::get($this->user_info->shop_id);
		$data['_pr']   = TransactionPurchaseRequisition::getPR($this->user_info->shop_id);
		return view('member.accounting_transaction.vendor.purchase_requisition.requisition_slip', $data);
	}
	public function getLoadRequisitionSlip(Request $request)
	{
		$data['_requisition_slip'] = RequisitionSlip::get($this->user_info->shop_id, $request->tab_type, 10, $request->search_keyword);
		return view('member.accounting_transaction.vendor.purchase_requisition.requisition_slip_table', $data);		
	}
	public function getCreate(Request $request)
	{
		$data['page'] = 'Create Purchase Requisition';
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data["_vendor"] = Vendor::getAllVendor('active');
        $data['transaction_refnum'] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'purchase_requisition');

        $data['action'] = '/member/transaction/purchase_requisition/create-submit';

        $pr_id = $request->id;
        Session::forget('applied_transaction');
        if($pr_id)
        {
        	$data['pr'] = RequisitionSlip::get_slip($this->user_info->shop_id, $pr_id);
        	$data['_prline'] = RequisitionSlip::get_slip_item($pr_id);
            $data['action'] = '/member/transaction/purchase_requisition/update-submit';
        }
        $data['count_transaction'] = TransactionPurchaseRequisition::countTransaction($this->user_info->shop_id);
		return view('member.accounting_transaction.vendor.purchase_requisition.create_requisition_slip', $data);
	}
	public function postCreateSubmit(Request $request)
	{
		$return = RequisitionSlip::create($this->user_info->shop_id, $this->user_info->user_id, $request);
		return json_encode($return);
	}
	public function postUpdateSubmit(Request $request)
	{
		$return = RequisitionSlip::update($this->user_info->shop_id, $this->user_info->user_id, $request);
		return json_encode($return);
	}
	public function getPrint(Request $request, $slip_id = 0)
	{
		$data['rs'] = RequisitionSlip::get_slip($this->user_info->shop_id, $slip_id);
		$data['_rs_item'] = RequisitionSlip::get_slip_item($slip_id);
        $data['user'] = $this->user_info;

        $footer = AccountingTransaction::get_refuser($this->user_info);

        $pdf = view('member.accounting_transaction.vendor.purchase_requisition.print_requisition_slip', $data);
        return Pdf_global::show_pdf($pdf,null, $footer);
	}
	public function getConfirm(Request $request, $slip_id)
    {
        $data['pr'] = RequisitionSlip::get_slip($this->user_info->shop_id, $slip_id);

        return view('member.accounting_transaction.vendor.purchase_requisition.pr_confirm', $data);
    }
    public function postConfirmSubmit(Request $request)
    {
        $pr_id = $request->id;

        $pr_status = $request->status;
        if($pr_status == 'confirm')
        {
            $update['requisition_slip_status'] = 'closed';
        }
        $return = RequisitionSlip::update_status($this->user_info->shop_id, $pr_id, $update);
        $data = RequisitionSlip::create_po($pr_id, $this->user_info->shop_id);
        $data = null;
        if($return)
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_confirm'; 
        }

        return json_encode($data);
    }
	public function getLoadTransaction()
	{
		$data['_so'] = TransactionSalesOrder::getAllOpenSO($this->user_info->shop_id);
		$data['_eq'] = TransactionEstimateQuotation::getAllOpenEQ($this->user_info->shop_id);

        $data['_applied'] = Session::get("applied_transaction");
		$data['action'] = '/member/transaction/purchase_requisition/apply-transaction';

		return view('member.accounting_transaction.vendor.purchase_requisition.load_transaction', $data);
	}

    public function postApplyTransaction(Request $request)
    {
        $_transaction = $request->_apply_transaction;
        
        Session::put('applied_transaction', $_transaction);

        $return['call_function'] = "success_apply_transaction";
        $return['status'] = "success";

        return json_encode($return);
    }
    public function getLoadAppliedTransaction(Request $request)
    {
        $applied_transaction = Session::get('applied_transaction');

        $return = null;
        $remarks = null;
        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value) 
            {
                $get = TransactionSalesOrder::info_item($key);
                $info = TransactionSalesOrder::info($this->user_info->shop_id, $key);

                foreach ($get as $key_item => $value_item)
                {
                    if($value_item->item_type_id == 1 || $value_item->item_type_id == 4 || $value_item->item_type_id == 5)
                    {
                        $return[$key.'i'.$key_item]['so_id'] = $value_item->estline_est_id;
                        $return[$key.'i'.$key_item]['item_id'] = $value_item->estline_item_id;
                        $return[$key.'i'.$key_item]['item_description'] = $value_item->estline_description;
                        $return[$key.'i'.$key_item]['multi_um_id'] = $value_item->multi_um_id;
                        $return[$key.'i'.$key_item]['item_um'] = $value_item->estline_um;
                        $return[$key.'i'.$key_item]['item_qty'] = $value_item->estline_qty;
                        $return[$key.'i'.$key_item]['item_rate'] = $value_item->estline_rate;
                        $return[$key.'i'.$key_item]['item_amount'] = $value_item->estline_amount;
                        $return[$key.'i'.$key_item]['item_rate'] = $value_item->estline_rate;
                    }
                }
                if($info)
                {
                    $remarks .= $info->transaction_refnum != "" ? $info->transaction_refnum.', ' : 'SO#'.$info->est_id.', ';
                }
            }
        }
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data['_transactions'] = $return;
        $data['remarks'] = $remarks;
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["_vendor"] = Vendor::getAllVendor('active');

        return view('member.accounting_transaction.vendor.purchase_requisition.applied_transaction', $data);
    }
}