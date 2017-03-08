<?php
namespace App\Globals;

use DB;

use App\Http\Controllers\Member\MLM_ProductController;

use App\Models\Tbl_settings;
use App\Models\Tbl_product_search;
use App\Models\Tbl_shop;

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
}