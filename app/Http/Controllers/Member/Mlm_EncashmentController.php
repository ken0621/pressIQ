<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Response;
use View;
use Crypt;
use PDF;
use App;
use DB;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_encashment_settings;
use App\Models\Tbl_mlm_encashment_process;

use App\Globals\Item;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_complan_manager_cd;
use App\Globals\Mlm_tree;
use App\Globals\Membership_code;
use App\Globals\Settings;
use App\Globals\Mlm_voucher;
use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Mlm_complan_manager_repurchase;
use App\Globals\Mlm_encash;
use App\Globals\Mlm_member;
use App\Globals\Pdf_global;
use App\Globals\Utilities;
use App\Globals\AuditTrail;

class Mlm_EncashmentController extends Member
{
    public function index()
    {
        $access = Utilities::checkAccess('mlm-wallet-encashment', 'access_page');
        if($access == 0)
        {
            return $this->show_no_access(); 
        }
        $data = [];
        $shop_id = $this->user_info->shop_id;
        $count = Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->count();
        $this->initialize_settings($shop_id);
        $data['encashment_settings'] = Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->first();
        $data['payout_gateway'] = payout_getway();

        $data['not_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','!=', 'ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->whereNull('encashment_process')
            ->sum('wallet_log_amount');
        $data['not_encashed_requested'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 0)
            ->sum('wallet_log_amount');    

         $data['not_encashed_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 1)
            ->sum('wallet_log_amount'); 

        if($data['encashment_settings']->enchasment_settings_auto == 0)
        {
            $data['encashment_process'] = Tbl_mlm_encashment_process::where('shop_id', $shop_id)
            ->orderBy('encashment_process', 'DESC')->get();
        }
        else
        {
            $history = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'ENCASHMENT')
            ->slot()->customer()
            ->where('tbl_mlm_slot.shop_id', $shop_id);
            $request = Request::input('request');
            $slot = Request::input('slots');
            $customer = Request::input('customer');
            if($request != null)
            {
                $history = $history->where('encashment_process_type', $request);
            }
            else
            {
                $history = $history->where('encashment_process_type', 0);
            }
            if($slot != null)
            {
                $history = $history->where('slot_no', 'like', '%' . $slot . '%');
            }
            if($customer != null)
            {
                $history = $history->leftjoin('tbl_customer_search', 'tbl_customer_search.customer_id', '=', 'tbl_customer.customer_id')
                ->where('tbl_customer_search.body', 'like', '%' . $customer . '%');
            }
            $data['history'] = $history->join('tbl_mlm_encashment_process', 'tbl_mlm_encashment_process.encashment_process', '=', 'tbl_mlm_slot_wallet_log.encashment_process')
            ->paginate(10);
        }
        
        $data['from'] = $this->get_last_wallet($shop_id);
        return view('member.mlm_encashment.index', $data);
    }
    public function get_last_wallet($shop_id)
    {
        $date_last = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)->whereNull('encashment_process')->first();
        if($date_last == null)
        {
            return Carbon::now();
        }
        else
        {
            return $date_last->wallet_log_date_created;
        }
    }
    public static function initialize_settings($shop_id)
    {
        $count = Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->count();
        if($count == 0)
        {
            $insert['shop_id'] = $shop_id;
            $insert['enchasment_settings_auto'] = 0;
            $insert['enchasment_settings_tax'] = 0;
            $insert['enchasment_settings_tax_type'] = 0;
            $insert['enchasment_settings_p_fee'] = 0;
            $insert['enchasment_settings_p_fee_type'] = 0;
            Tbl_mlm_encashment_settings::insert($insert);
        }
    }
    public function update_settings()
    {
        $enchasment_settings_id = Request::input('enchasment_settings_id');
        $old_data = AuditTrail::get_table_data("tbl_mlm_encashment_settings","enchasment_settings_id",$enchasment_settings_id);
        $update['enchasment_settings_auto'] = Request::input('enchasment_settings_auto');
        $update['enchasment_settings_tax'] = Request::input('enchasment_settings_tax');
        $update['enchasment_settings_tax_type'] = Request::input('enchasment_settings_tax_type');
        $update['enchasment_settings_p_fee'] = Request::input('enchasment_settings_p_fee');
        $update['enchasment_settings_p_fee_type'] = Request::input('enchasment_settings_p_fee_type');
        $update['enchasment_settings_minimum'] = Request::input('enchasment_settings_minimum');
        $update['enchasment_settings_type'] = Request::input('enchasment_settings_type');

        Tbl_mlm_encashment_settings::where('enchasment_settings_id', $enchasment_settings_id)->update($update);
        $data['status'] = 'success';
        $data['message'] = 'Encashment Settings Changed';

        //audit

        $new_data = AuditTrail::get_table_data("tbl_mlm_encashment_settings","enchasment_settings_id",$enchasment_settings_id);
        AuditTrail::record_logs("Edited","mlm_encashment_settings",$enchasment_settings_id,serialize($old_data),serialize($new_data));
        
        return json_encode($data);
    }
    public function process_all_encashment()
    {
        ini_set('max_execution_time', 60000);
        set_time_limit(10000);
        $shop_id = $this->user_info->shop_id;
        $enchasment_process_from = Request::input('enchasment_process_from');
        $enchasment_process_to = Request::input('enchasment_process_to');
        if($enchasment_process_from <= $enchasment_process_to)
        {
            $encashment_settings = Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->first();

            $insert['shop_id'] = $shop_id;
            $insert['enchasment_process_from'] = Request::input('enchasment_process_from');
            $insert['enchasment_process_to'] = Request::input('enchasment_process_to');
            $insert['enchasment_process_executed'] = Carbon::now();
            $insert['enchasment_process_tax'] = $encashment_settings->enchasment_settings_tax;
            $insert['enchasment_process_tax_type'] = $encashment_settings->enchasment_settings_tax_type;
            $insert['enchasment_process_p_fee'] = $encashment_settings->enchasment_settings_p_fee;
            $insert['enchasment_process_p_fee_type'] = $encashment_settings->enchasment_settings_p_fee_type;
            $insert['enchasment_process_minimum'] =  $encashment_settings->enchasment_settings_minimum;
            $insert['encashment_process_sum'] = 0;
            $id = Tbl_mlm_encashment_process::insertGetId($insert);
            return Mlm_slot_log::encash_all($id);
            $data['status'] = 'success';
            $data['message'] = 'Encashment Process';
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'] = 'Encashment date mismatch';
        }
        return json_encode($data);
    }
    public function view_process($encashment_process)
    {
        $shop_id = $this->user_info->shop_id;
        $data['encashment_process'] = Tbl_mlm_encashment_process::where('shop_id', $shop_id)
        ->where('encashment_process', $encashment_process)
        ->orderBy('encashment_process', 'DESC')->first();
        $data['slots'] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'ENCASHMENT')
        ->where('encashment_process', $encashment_process)
        ->slot()->customer()->get();
        return view('member.mlm_encashment.view', $data);
    }
    public function breakdown_slot($encashment_process, $slot_id, $pdf = null)
    {
        $shop_id = $this->user_info->shop_id;

        $data['slot'] = Tbl_mlm_slot::where('slot_id', $slot_id)->customer()->first();
        $data['encashment_process'] = Tbl_mlm_encashment_process::where('shop_id', $shop_id)
        ->where('encashment_process', $encashment_process)
        ->orderBy('encashment_process', 'DESC')->first();

        $data['log'] = $data['slots'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', $slot_id)
        ->where('wallet_log_plan', '!=', 'ENCASHMENT')
        ->orderBy('wallet_log_id', 'ASC')
        ->where('encashment_process', $encashment_process)
        ->slot()->customer()->get();

        $data['log_final'] = $data['slots'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', $slot_id)
        ->where('wallet_log_plan','ENCASHMENT')
        ->orderBy('wallet_log_id', 'ASC')
        ->where('encashment_process', $encashment_process)
        ->slot()->customer()->first();

        $data['encashment_details'] = DB::table('tbl_mlm_encashment_process_details')->where('encashment_process', $encashment_process)->first();
        
        if(isset($data['slot']->customer_id))
        {
            $data['customer_view'] = Mlm_member::get_customer_info_w_slot($data['slot']->customer_id, $slot_id);
        }
        if($pdf == true){
            return view('member.mlm_encashment.pdf', $data);
        }
        else
        {
            return view('member.mlm_encashment.breakdown', $data);
        }
    }
    public function process_breakdown()
    {
        $update['encashment_process_type'] = 1;
        $update['wallet_log_remarks'] = Request::input('wallet_log_remarks');
        $wallet_log_id   = Request::input('wallet_log_id');
        $encashment_process = Request::input('encashment_process');
        $slot_id = Request::input('slot_id');
        Tbl_mlm_slot_wallet_log::where('wallet_log_id', $wallet_log_id)->update($update);
        $data['status'] = 'success_process';
        $data['message'] = 'Encashment Processed';
        $data['wallet_log_id'] =    $wallet_log_id;
        $data['encashment_process'] = $encashment_process;
        $data['slot_id'] = $slot_id;
        return json_encode($data);
    }
    public function show_pdf($encashment_process, $slot_id)
    {
        $html_a = $this->breakdown_slot($encashment_process, $slot_id, 'true');
        return Pdf_global::show_pdf($html_a);
    }
    public function show_type($type)
    {
        $shop_id = $this->user_info->shop_id;
        $data['encashment_settings'] = Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->first();
        if($type == 0)
        {
            $data['bank_option'] = DB::table('tbl_encashment_bank_deposit')->where('shop_id', $shop_id)->where('encashment_bank_deposit_archive', 0)->get();
            return view('member.mlm_encashment.type.bank', $data);
        }
        else if($type == 1)
        {
            return view('member.mlm_encashment.type.cheque', $data);
        }
    }
    public function cheque_edit()
    {
        $shop_id = $this->user_info->shop_id;
        $update['enchasment_settings_cheque_edit'] = Request::input('enchasment_settings_cheque_edit');
        Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->update($update);

        $data['status'] = 'success_new';
        $data['message'] = 'Name on cheque option editted';
        return json_encode($data);
    }
    public function bank_add()
    {
            // return $_POST;
            $shop_id = $this->user_info->shop_id;
            if($_POST['encashment_bank_deposit_name'] != null)
            {
                $insert['encashment_bank_deposit_name'] = Request::input('encashment_bank_deposit_name');
                $insert['shop_id'] = $shop_id;
                $insert['encashment_bank_deposit_archive'] = 0;
                DB::table('tbl_encashment_bank_deposit')->insert($insert);
                $data['status'] = 'success_new';
                $data['message'] = 'Bank option added.';
            }
            else
            {
                $data['status'] = 'warning';
                $data['message'] = 'Bank deposit name is required';
            }
            return json_encode($data);
    }
    public function bank_archive()
    {
        $shop_id = $this->user_info->shop_id;
        $encashment_bank_deposit_id = Request::input('encashment_bank_deposit_id');
        $update['encashment_bank_deposit_archive']  = 1;
        DB::table('tbl_encashment_bank_deposit')->where('encashment_bank_deposit_id', $encashment_bank_deposit_id)->update($update);
        $data['status'] = 'success_new';
        $data['message'] = 'Bank option archived.';
        return json_encode($data);

    }
    public function bank_edit_name()
    {
        $shop_id = $this->user_info->shop_id;
        $update['enchasment_settings_bank_edit'] = Request::input('enchasment_settings_bank_edit');
        Tbl_mlm_encashment_settings::where('shop_id', $shop_id)->update($update);

        $data['status'] = 'success_new';
        $data['message'] = 'Bank account name option editted';
        return json_encode($data);
    }
}