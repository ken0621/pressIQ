<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use File;
use Input;
use Validator;
use Carbon\Carbon;
use URL;
use Session;
use DB;

use App\Globals\Mlm_member;
use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Cart;
use App\Globals\Customer;
use App\Globals\Ec_order;
use App\Models\Tbl_customer;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_coupon_code_product;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_item_code;
use App\Models\Tbl_country;
use App\Models\Tbl_online_pymnt_method;
use App\Models\Tbl_item;
use App\Models\Tbl_item_code_item;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_merchant_school;
use App\Models\Tbl_locale;
use App\Models\Tbl_email_template;
use App\Globals\Mail_global;
use App\Globals\Payment;  
use App\Models\Tbl_online_pymnt_api;

class ShopPaymentFacilityController extends Shop
{
    public function paymaya_webhook_success()
    {
        $data = Request::input();
        Payment::done($data);
    }
    public function paymaya_webhook_failure()
    {
        $data = Request::input();
        Payment::done($data);
    }
    public function paymaya_webhook_cancel()
    {
        $data = Request::input();
        Payment::done($data);
    }
}
