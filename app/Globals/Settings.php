<?php
namespace App\Globals;

use DB;
use Config;

use App\Http\Controllers\Member\MLM_ProductController;

use App\Models\Tbl_settings;
use App\Models\Tbl_product_search;
use App\Models\Tbl_shop;
use App\Models\Tbl_mlm_encashment_currency;

class Settings
{
	public static function get_settings($key)
	{
		header('Access-Control-Allow-Origin: *');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json'); 
		$shop_id = MLM_ProductController::checkuser('user_shop');
		if($key != null)
		{
			$setting = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->first();
			if($setting != null)
			{
				if(isset($setting->settings_value))
				{
					$data['response_status'] = 'success';
					$data['settings_key'] = $setting->settings_key;
					$data['settings_value'] = $setting->settings_value;
				}
				else
				{
					$data['response_status'] = 'error';
					$data['message'] = 'Invalid Settings Key';
				}
				
			}
			else
			{
				$data['response_status'] = 'error';
				$data['message'] = 'Invalid Settings Key';
			}
		}
		else
		{
			$data['response_status'] = 'error';
			$data['message'] = 'Settings key must not be null';
		}
		echo json_encode($data);
	}
	public static function get_settings_php($key)
	{
		$shop_id = MLM_ProductController::checkuser('user_shop');
		if($key != null)
		{
			$setting = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->first();
			if($setting != null)
			{
				if(isset($setting->settings_value))
				{
					$data['response_status'] = 'success';
					$data['settings_key'] = $setting->settings_key;
					$data['settings_value'] = $setting->settings_value;
				}
				else
				{
					$data['response_status'] = 'error';
					$data['message'] = 'Invalid Settings Key';
				}
				
			}
			else
			{
				$data['response_status'] = 'error';
				$data['message'] = 'Invalid Settings Key';
			}
		}
		else
		{
			$data['response_status'] = 'error';
			$data['message'] = 'Settings key must not be null';
		}
		return $data;
	}
	public static function get_settings_php_shop_id($key, $shop_id)
	{
		if($key != null)
		{
			$setting = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->first();
			if($setting != null)
			{
				if(isset($setting->settings_value))
				{
					$data['response_status'] = 'success';
					$data['settings_key'] = $setting->settings_key;
					$data['settings_value'] = $setting->settings_value;
				}
				else
				{
					$data['response_status'] = 'error';
					$data['message'] = 'Invalid Settings Key';
				}
				
			}
			else
			{
				$data['response_status'] = 'error';
				$data['message'] = 'Invalid Settings Key';
			}
		}
		else
		{
			$data['response_status'] = 'error';
			$data['message'] = 'Settings key must not be null';
		}
		return $data;
	}
	public static function update_settings($key, $value)
	{
		$shop_id = MLM_ProductController::checkuser('user_shop');
		if($key != null)
		{
			$setting = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->first();
			if($setting != null)
			{
				if(isset($setting->settings_value))
				{
					$update['settings_value'] = $value;
					$updata['settings_setup_done'] = 1;
					$setting = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->update($update);
					$data['response_status'] = 'success';
					$data['settings_key'] = $key;
					$data['settings_value'] = $value;
				}
				else
				{
					$data['response_status'] = 'error';
					$data['message'] = 'Invalid Settings Key';
				}
				
			}
			else
			{
				$data['response_status'] = 'error';
				$data['message'] = 'Invalid Settings Key';
			}
		}
		else
		{
			$data['response_status'] = 'error';
			$data['message'] = 'Settings key must not be null';
		}
		return $data;
	}
	public static function set_mail_setting($shop_id)
	{
		// $setting = collect(DB::table("tbl_settings")->where("shop_id", $shop_id)->get())->keyBy('settings_key');
		// foreach ($setting as $key => $value) 
		// {
		// 	switch ($key) 
		// 	{
		// 		case 'mail_driver':
		// 			Config::set('mail.driver', $value->settings_value);
		// 		break;
		// 		case 'mail_host':
		// 			Config::set('mail.host', $value->settings_value);
		// 		break;
		// 		case 'mail_port':
		// 			Config::set('mail.port', $value->settings_value);
		// 		break;
		// 		case 'mail_username':
		// 			Config::set('mail.username', $value->settings_value);
		// 		break;
		// 		case 'mail_password':
		// 			Config::set('mail.password', $value->settings_value);
		// 		break;
		// 		case 'mail_encryption':
		// 			Config::set('mail.encryption', $value->settings_value);
		// 		break;
		// 		default:
		// 			# code...
		// 		break;
		// 	}
		// }
	}
	public static function set_currency_default($shop_id)
    {
        $insert['en_cu_convertion'] = 1;
        $insert['en_cu_active'] = 1;
        $insert['iso'] = 'PHP';
        $insert['en_cu_shop_id'] = $shop_id;
        $insert['en_cu_default'] = 1;
        $count = Tbl_mlm_encashment_currency::where('iso', $insert['iso'])
        ->where('en_cu_shop_id', $shop_id)->count();

        if($count == 0)
        {
            Tbl_mlm_encashment_currency::insert($insert);
        }
    }
}