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
		$data['_pr']   = TransactionPurchaseRequisition::getAllOpenPR($this->user_info->shop_id);
		//dd($data['_pr']);//dd($data['_list']);
		return view('member.accounting_transaction.vendor.purchase_requisition.requisition_slip', $data);
	}
	public function getLoadRsTable(Request $request)
	{
		$data['_list'] = RequisitionSlip::get($this->user_info->shop_id, $request->status);

		return view('member.accounting_transaction.vendor.purchase_requisition.requisition_slip_table', $data);		
	}
	public function getCreate()
	{
		$data['page'] = 'Create Purchase Requisition';
        $data['_item']  = Item::get_all_category_item([1]);
        $data["_vendor"] = Vendor::getAllVendor('active');
        $data['count_so'] = TransactionPurchaseRequisition::countTransaction($this->user_info->shop_id);
		return view('member.accounting_transaction.vendor.purchase_requisition.create_requisition_slip', $data);
	}
	public function postCreateSubmit(Request $request)
	{
		$return = RequisitionSlip::create($this->user_info->shop_id, $this->user_info->user_id, $request);
		return json_encode($return);
	}
	public function getPrint(Request $request, $slip_id = 0)
	{
		$data['rs'] = RequisitionSlip::get_slip($this->user_info->shop_id, $slip_id);
		$data['_rs_item'] = RequisitionSlip::get_slip_item($slip_id);
        $data['user'] = $this->user_info;

        $pdf = view('member.accounting_transaction.vendor.purchase_requisition.print_requisition_slip', $data);
        return Pdf_global::show_pdf($pdf,null, $data['rs']->requisition_slip_number);
	}
	public function getConfirm(Request $request, $slip_id = 0)
	{
		dd(123);
	}
	public function getLoadTransaction()
	{
		$data['_so'] = TransactionSalesOrder::getAllOpenSO($this->user_info->shop_id);

		return view('member.accounting_transaction.vendor.purchase_requisition.load_transaction', $data);
	}
}