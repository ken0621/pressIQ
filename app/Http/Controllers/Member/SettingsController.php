<?php
namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;

use App\Models\Currency;
use App\Models\Tbl_country;
use App\Models\Tbl_settings;

use App\Globals\Settings;
class SettingsController extends Member
{   
    public function all()
    {
        $shop_id = $this->user_info->shop_id;
        $data['settings_setup'] = $this->setup();
        $data['selected_settings'] = 'all';
        $settings_active = Tbl_settings::where('shop_id', $shop_id)->get();
        $settings_active = Tbl_settings::where('shop_id', $shop_id)->get();
        $data['settings_active'] = [];
        foreach($settings_active as $settings)
        {
            $data['settings_active'][$settings->settings_key]['settings_value'] = $settings->settings_value;
            $data['settings_active'][$settings->settings_key]['settings_setup_done'] = $settings->settings_setup_done;
        }
        return view('member.settings.settings_all', $data);
    }
    public function index($key)
    {
        $shop_id = $this->user_info->shop_id;
        $data = [];
        $data['selected_settings'] = $key;
        $settings_active = Tbl_settings::where('shop_id', $shop_id)->get();
        $data['settings_active'] = [];
        foreach($settings_active as $settings)
        {
            $data['settings_active'][$settings->settings_key]['settings_value'] = $settings->settings_value;
            $data['settings_active'][$settings->settings_key]['settings_setup_done'] = $settings->settings_setup_done;
        }

        $data['settings_setup'] = $this->setup();

        return view('member.settings.settings_modal', $data);
    }
    public function setup()
    {
        // Set your required data here
        $data['currency'] = Currency::get();
        $data['country'] =  Tbl_country::get();
        // end
        return view('member.settings.settings', $data);
    }
    public function verify()
    {
        // return $_POST;
        $key = Request::input('settings_key');
        $type = Request::input('update_type');
        if($type == "add")
        {
            if($key != null)
            {
                $shop_id = $this->user_info->shop_id;
                $count_settings = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->count();
                if($count_settings == 0)
                {
                    $insert['settings_key'] = Request::input('settings_key');
                    $insert['settings_value'] = Request::input('settings_value');
                    $insert['shop_id'] = $shop_id;
                    Tbl_settings::insert($insert);

                    $data['response_status'] = "success_viery";
                    $data['message'] = "Success";
                }
                else
                {
                    // success_viery
                    $count_not_setup = Tbl_settings::where('settings_key', $key)
                    ->where('shop_id', $shop_id)
                    ->where('settings_setup_done', 0)
                    ->count();
                    if($count_not_setup >= 1)
                    {
                        $data['response_status'] = "success_viery";
                        $data['message'] = "Success";
                    }
                    else
                    {
                        $data['response_status'] = "success_already";
                        $data['message'] = "Success";
                    }
                }
            }
            else
            {
                $data['response_status'] = "error";
                $data['message'] = "Invalid Settings";
            }
        }
        else
        {
            if($key != null)
            {
                $shop_id = $this->user_info->shop_id;
                $count_settings = Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->count();
                if($count_settings == 0)
                {
                    $insert['settings_key'] = Request::input('settings_key');
                    $insert['settings_value'] = Request::input('settings_value');
                    $insert['shop_id'] = $shop_id;
                    Tbl_settings::insert($insert);

                    $data['response_status'] = "success_viery";
                    $data['message'] = "Success";
                }
                else
                {
                    $update['settings_value'] = Request::input('settings_value');
                    $update['settings_setup_done'] = 1;
                    Tbl_settings::where('settings_key', $key)->where('shop_id', $shop_id)->update($update);
                    
                    $data['form_input'] = $update;
                    $data['response_status'] = "success_update";
                    $data['message'] = "Success";
                }
                
            }
            else
            {
                $data['response_status'] = "error";
                $data['message'] = "Invalid Settings";
            }   
        }
        echo json_encode($data);
    }
    public function get_settings($key)
    {
        return Settings::get_settings($key);
    }
    public function initial_setup()
    {
        $shop_id = $this->user_info->shop_id;
        $settings_active = Tbl_settings::where('shop_id', $shop_id)->get();
        $data['selected_settings'] = 'all';
        $data['settings_active'] = [];
        foreach($settings_active as $settings)
        {
            $data['settings_active'][$settings->settings_key]['settings_value'] = $settings->settings_value;
            $data['settings_active'][$settings->settings_key]['settings_setup_done'] = $settings->settings_setup_done;
        }
        $data['settings_setup'] = $this->setup();
        return view('member.settings.settings_n_modal', $data);
    }
}