<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_receive_payment;
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
 * Receive Payment Module - all payment related module
 *
 * @author Bryan Kier Aradanas
 */

class ReceivePayment
{

    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function postPayment()
    {
    	
    }
}