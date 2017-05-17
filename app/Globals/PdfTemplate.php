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
use App\Globals\Item;
use App\Globals\UnitMeasurement;
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

class PdfTemplate
{

    public static function getShopId()
    {
    	return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
   
}