<?php

namespace App\Http\Controllers\Member;

use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Globals\Accounting;
use App\Globals\Invoice;
use App\Globals\Category;
use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;

class ChartOfAccountController extends Member
{
    public function index()
    {
        $data['_account_type']  = Tbl_chart_account_type::get();
        $data['_account']       = Accounting::getAllAccount();
        // dd($data['_account']);
        // $data['_account_view']  = view('member.');
        return view('member/accounting/chart_of_account', $data);
    }

    public function load_coa()
    {
        $filter = Request::input('filter');
        $data['_account']       = Accounting::getAllAccount('all', null, $filter);
        $data['add_search']     = '';
        return view('member.load_ajax_data.load_chart_account', $data);
    }
     
    public function add_account()
    {
        $data['account_shop_id']            = $this->user_info->shop_id;
        $data['account_type_id']            = Request::input('account_type_id');
        $data['account_number']             = Request::input('account_number');
        $data['account_name']               = Request::input('account_name');
        $data['account_description']        = Request::input('account_description');
        $data['account_parent_id']          = Request::input('account_parent_id');
        $data['account_parent_id']          = null;
        $data['account_sublevel']           = 0;
        $data['account_timecreated']        = Carbon::now();
        
        /* IF THE SUB-ACCOUNT IS CHECKED */
        if(Request::input('is_sub_account') == "on")
        {
            $parent_id                      = Request::input('account_parent_id');
            $sub_level                      = Tbl_chart_of_account::where("account_id", $parent_id)->pluck("account_sublevel");
            $data['account_parent_id']      = $parent_id;
            $data['account_sublevel']       = $sub_level + 1;
        }
        
        /* IF THE ACCOUNT TYPE HAS OPEN BALANCE FIELD */
        if(Tbl_chart_account_type::where("chart_type_id", Request::input('account_type_id'))->pluck("has_open_balance") == 1)
        {
            $data['account_open_balance']       = Request::input('account_open_balance');
            $data['account_open_balance_date']  = date_format(date_create(Request::input('account_open_balance_date')) ,"Y/m/d");
            
            $rules['account_open_balance']      = "required";
            $rules['account_open_balance_date'] = "required";
        }
        
        $rules['account_type_id']           = "required";
        $rules['account_number']            = "required";
        $rules['account_name']              = "required";
        $rules['account_sublevel']          = "required";
        // $rules['account_open_balance']       = "required";
        // $rules['account_open_balance_date']  = "required";

        /* IF DUPLICATION OF ACCOUNT NAME */
        $account_name = Tbl_chart_of_account::where("account_shop_id", $this->user_info->shop_id)->where("account_name", $data['account_name'])->pluck("account_name"); 
        
        $validator = Validator::make($data, $rules);

        if($validator->fails() || $account_name)
        {
            $json['response_status']= "error";
            $json['title']          = "Error adding a new account";
            $json['message']        = 'Duplicate Name "'.$account_name.'"';

            foreach($validator->errors()->all() as $validate)
            {
                $json['message']    = $json['message'] ."</br>" .$validate;
            }
            // $json['message']       = $validator->errors()->all();
            
            return json_encode($json);
        }
        
        $account_id = Tbl_chart_of_account::insertGetId($data);
        
        Request::session()->flash('success', 'Account Successfully added');
        
        $json['response_status']= "success";
        $json['type']           = "account";
        $json['id']             = $account_id;
        $json['redirect_to']    = Redirect::back()->getTargetUrl();
        return json_encode($json);
    }
    
    public function update_account($account_id)
    {
        $data['account_type_id']            = Request::input('account_type_id');
        $data['account_number']             = Request::input('account_number');
        $data['account_name']               = Request::input('account_name');
        $data['account_description']        = Request::input('account_description');
        $data['account_parent_id']          = Request::input('account_parent_id');
        $data['account_parent_id']          = null;
        $data['account_sublevel']           = 0;
        
        /* IF THE SUB-ACCOUNT IS CHECKED */
        if(Request::input('is_sub_account') == "on")
        {
            $parent_id                      = Request::input('account_parent_id');
            $sub_level                      = Tbl_chart_of_account::where("account_id", $parent_id)->pluck("account_sublevel");
            $data['account_parent_id']      = $parent_id;
            $data['account_sublevel']       = $sub_level + 1;
        }
        
        /* IF THE ACCOUNT TYPE HAS OPEN BALANCE FIELD */
        if(Tbl_chart_account_type::where("chart_type_id", Request::input('account_type_id'))->pluck("has_open_balance") == 1)
        {
            $data['account_open_balance']       = Request::input('account_open_balance');
            $data['account_open_balance_date']  = date_format(date_create(Request::input('account_open_balance_date')) ,"Y/m/d");
            
            $rules['account_open_balance']      = "required";
            $rules['account_open_balance_date'] = "required";
        }
        
        $rules['account_type_id']           = "required";
        $rules['account_number']            = "required";
        $rules['account_name']              = "required";
        $rules['account_sublevel']          = "required";
        
        /* IF DUPLICATION OF ACCOUNT NAME */
        $account_name = Tbl_chart_of_account::where("account_shop_id", $this->user_info->shop_id)->where("account_name", $data['account_name'])->where("account_id","<>",$account_id)->pluck("account_name"); 

        $validator = Validator::make($data, $rules);

        if($validator->fails() || $account_name)
        {
            $json['response_status']= "error";
            $json['title']          = "Error adding a new account";
            $json['message']        = "";

            if($account_name)
            {
                $json['message']    = 'Duplicate Name "'.$account_name.'"';
            }
            foreach($validator->errors()->all() as $validate)
            {                dd($valida);
                $json['message']    = $json['message'] ."</br>" .$validate;
            }
            
            return json_encode($json);
        }
        
        Tbl_chart_of_account::where("account_id", $account_id)->update($data);
        
        Request::session()->flash('success', 'Account Successfully updated');

        $json['response_status']= "success";
        $json['redirect_to']    = Redirect::back()->getTargetUrl();
        return json_encode($json);
    }
    
    public function load_add_account()
    {
        $data['_account_type']  = Tbl_chart_account_type::get();
        $data['_account']       = Tbl_chart_of_account::accountInfo($this->user_info->shop_id)->get();
        return view('/member/accounting/modal/account_add', $data);
    }
    
    public function load_update_account($id)
    {
        $data['account_info']   = Tbl_chart_of_account::accountInfo($this->user_info->shop_id)->where("account_id", $id)->first();
        $data['_account_type']  = Tbl_chart_account_type::get();
        $data['_account']       = Tbl_chart_of_account::accountInfo($this->user_info->shop_id)->get();
        return view('/member/accounting/modal/account_update', $data);
    }

}