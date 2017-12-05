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
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use App\Globals\Item;
use App\Globals\AuditTrail;
use App\Globals\RequisitionSlip;
use Validator;
use Excel;
use DB;
class RequisitionSlipController extends Member
{
	public function getIndex()
	{
		$data['page'] = 'Requisition Slip';
		return view('member.requisition_slip.requisition_slip', $data);
	}
	public function getCreate()
	{
		$data['page'] = 'Create Requisition Slip';
        $data['_item']  = Item::get_all_category_item([1]);
        $data["_vendor"] = Vendor::getAllVendor('active');
		return view('member.requisition_slip.create_requisition_slip', $data);
	}
	public function postCreateSubmit(Request $request)
	{

	}
}