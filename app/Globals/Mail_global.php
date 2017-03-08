<?php
namespace App\Globals;

use App\Models\Tbl_item;
use App\Models\Tbl_item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_customer;

use App\Globals\Mlm_voucher;
use App\Globals\Item;
use App\Globals\Item_code;
use App\Globals\Mlm_compute;

use Session;
use Carbon\Carbon;
use Validator;
use Mail;
class Mail_global
{
	public function mail()
    {

    }
    public static function mail_discount_card($discount_card_log_id)
    {
    	$data = [];
    	$data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_log_id', $discount_card_log_id)->first();
    	$data['customer'] = Tbl_customer::where('customer_id', $data['discount_card']->discount_card_customer_holder)->first();
    	$data['customer_sponsor'] = Tbl_customer::where('customer_id', $data['discount_card']->discount_card_customer_sponsor)->first();
	       Mail::send('emails.discount_card', $data, function ($m) use ($data) {
	            $m->from(env('MAIL_USERNAME'), $_SERVER['SERVER_NAME']);

	            $m->to($data['customer']->email, env('MAIL_USERNAME'))->subject('Discount Card');
	        });

    }
}