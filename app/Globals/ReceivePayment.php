<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_credit_memo;
use App\Globals\AuditTrail;
use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * Receive Payment Module - all payment related module
 *
 * @author Bryan Kier Aradanas
 */

class ReceivePayment
{

    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }

    public static function updateCM($cm_id,$receive_payment_id)
    {
    	$up["cm_used_ref_name"] = "receive_payment";
    	$up["cm_used_ref_id"] = $receive_payment_id;
    	$up["cm_type"] = 1;

    	Tbl_credit_memo::where("cm_id",$cm_id)->update($up);
    }
    public function postPayment()
    {
    	
    }
}