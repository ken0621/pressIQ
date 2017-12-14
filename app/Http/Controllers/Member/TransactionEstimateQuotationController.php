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

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionEstimateQuotationController extends Member
{
	public function getIndex()
	{
		$data['page'] = "Estimate and Quotation";
		return view('member.accounting_transaction.customer.estimate_quotation.estimate_quotation_list',$data);
	}
	public function getCreate()
	{
		$data['page'] = "Create Estimate and Quotation";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

		return view('member.accounting_transaction.customer.estimate_quotation.estimate_quotation',$data);
	}
}