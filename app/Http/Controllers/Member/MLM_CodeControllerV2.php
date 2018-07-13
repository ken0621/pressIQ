<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\MLM2;
use App\Globals\Warehouse2;
use App\Globals\Pdf_global;
use App\Globals\Customer;
use App\Globals\Report;
use App\Globals\Sms;
use App\Globals\Mail_global;
use Excel;
use App\Globals\BarcodeGenerator;
use App\Globals\Transaction;
use Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Tbl_release_product_code;
use App\Models\Tbl_distribute_product_code;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_item_token_log;
use App\Models\Tbl_item_token;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_item_points;

use DB;

class MLM_CodeControllerV2 extends Member
{
    public function membership_code()
    {
    	$data["page"] = "Membership Code";
        Item::get_filter_type(5);
        $data["_item_kit"] = Item::get($this->user_info->shop_id);
        $data["_membership"] = MLM2::membership($this->user_info->shop_id);

        if(!$data["_item_kit"])
        {
            $data["title"] = "NO ITEM KIT FOUND";
            $data["content"] = "You need a <a href='/member/item/v2'>membership item kit</a> before you can use this module.";
            return view("member.error", $data);
        }
        elseif(!$data["_membership"])
        {
            $data["title"] = "NO MEMBERSHIP FOUND";
            $data["content"] = "You need to create a <a href='/member/item/v2'>membership</a> before you can use this module.";
            return view("member.error", $data);
        }
        else
        {
            return view("member.mlm_code_v2.membership_code", $data);
        }
    }
    public function membership_code_table(Request $request)
    {   
        $data['_assembled_item_kit'] = Item::get_assembled_kit(0, $request->item_kit_id, $request->item_membership_id, $request->search_keyword, $request->status,10);

        foreach ($data['_assembled_item_kit'] as $key => $value) 
        {
            $data['_assembled_item_kit'][$key]->used_by = null;
            if($value->record_consume_ref_name == 'customer_product_code')
            {
                $customer_info = Customer::info($value->record_consume_ref_id, $this->user_info->shop_id)['customer'];
                $data['_assembled_item_kit'][$key]->used_by = 'Used By Customer - '.ucwords($customer_info->first_name.' '.$customer_info->last_name);
            }
            if($value->record_consume_ref_name == 'transaction_list')
            {
                $data['_assembled_item_kit'][$key]->used_by = 'Used By SLOT NUMBER-'.strtoupper($value->slot_no).'';
            }
        }

        return view("member.mlm_code_v2.membership_code_table", $data);

    }
    public function membership_code_assemble(Request $request)
    {
        if($request->isMethod("post"))
        {
            $item_id            = $request->item_id;
            $quantity           = ($request->quantity <= 0 ? 1 : $request->quantity);
            
            $return_assemble = Item::assemble_membership_kit($this->user_info->shop_id, $this->current_warehouse->warehouse_id, $item_id, $quantity);

            if(!$return_assemble)
            {
                $response["status"] = "success";
                $response["call_function"] = "membership_code_assemble_success";
                $response["message"] = "<b>".$quantity." MEMBERSHIP KIT</b> CREATED";
            }
            else
            {
                $response["status"] = "error";
                $response["message"] = $return_assemble;
            }

            return json_encode($response);
        }
        else
        {
            $data["page"] = "Membership Code Assemble";
            Item::get_filter_type(5);
            $data["_item_kit"] = Item::get($this->user_info->shop_id);
            return view("member.mlm_code_v2.membership_code_assemble", $data);
        }

    }
    public function membership_code_assemble_table(Request $request)
    {
        $data["page"]       = "Membership Code Assemble - Table";
        $item_id            = $request->item_id;
        $quantity           = ($request->quantity <= 0 ? 1 : $request->quantity);
        $warehouse_id       = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        Item::get_inventory($warehouse_id);
        $item_info          = Item::info($item_id);
        $_item              = Item::get_item_from_bundle($item_id, $warehouse_id);
        $_new_item          = null;
        $data["allowed"]    = "true";
        foreach($_item as $key => $item)
        {
            $_new_item[$key]                = $item;
            $_new_item[$key]->required      = $item->bundle_qty * $quantity;

            if($_new_item[$key]->required > $item->inventory_count)
            {
                $data["allowed"]            = "false";
                $_new_item[$key]->required  = "<span style='color: red;'>" . $_new_item[$key]->required . "</span>";
            }
            else
            {
                $_new_item[$key]->required  = $item->bundle_qty * $quantity;
            }
        }

        $data["kit_quantity_limit"] = Item::bundle_count($item_id, $warehouse_id);
        $data["membership"] = MLM2::membership_info($this->user_info->shop_id, $item_info->membership_id);
        $data["_item"] = $_new_item;

        return view("member.mlm_code_v2.membership_code_assemble_table", $data);
    }
    public function membership_code_disassemble(Request $request)
    {
        if($request->isMethod("post"))
        {
            $record_log_id = $request->record_log_id;

            if ($record_log_id) 
            {
                foreach ($record_log_id as $key => $value) 
                {
                    Item::disassemble_membership_kit($value);
                }
            }
            
            $return['status'] = 'success';
            $return['call_function'] = 'success_dissamble';
            
            return json_encode($return);
        }
        else
        {
            $record_id = $request->record_id;

            $data['_assembled_item_kit'] = Item::get_assembled_kit($record_id);
            if(!$record_id)
            {
                $data['_assembled_item_kit'] = Item::get_assembled_kit();
            }

            return view("member.mlm_code_v2.membership_code_disassemble",$data);            
        }
    }
    public function change_status(Request $request)
    { 
        if($request->isMethod("post"))
        {
            $status = $request->action_status;
            $reserved_customer = $request->reserved_customer;
            $record_log_id = $request->record_log_id;
            
            $update['record_consume_ref_name'] = NULL;
            $update['record_consume_ref_id'] = 0;

            if($status == 'reserved')
            {
                $update['record_consume_ref_name'] = $status;
                $update['record_consume_ref_id'] = $reserved_customer;
            }
            if($status == 'block')
            {
                $update['record_consume_ref_name'] = $status;                
            }
            $update['record_item_remarks'] = $request->remarks;

            Warehouse2::update_warehouse_item($record_log_id, $update);

            $return['status'] = 'success';
            $return['call_function'] = 'success_change_status';

            return json_encode($return);
        }
        else
        {
            $data['action'] = $request->action;
            $data['item'] = Item::info($request->item_id);

            $data['record_log_id'] = $request->record_id;
            $data["_customer"]  = Customer::getAllCustomer();


            return view("member.mlm_code_v2.membership_code_change_status",$data);              
        }
    }
    public function index()
    {
        $data['page'] = "Product Code";
        return view("member.mlm_code_v2.product_code",$data);
    }
    public function product_code_table(Request $request)
    {
        $data['_item_product_code'] = Item::get_all_item_record_log($request->search_keyword, $request->status, 10);
        foreach ($data['_item_product_code'] as $key => $value) 
        {
            $data['_item_product_code'][$key]->used_by = null;
            if($value->record_consume_ref_name == 'customer_product_code')
            {
                $customer_info = Customer::info($value->record_consume_ref_id, $this->user_info->shop_id)['customer'];
                $data['_item_product_code'][$key]->used_by = 'Used By Customer - '.ucwords($customer_info->first_name.' '.$customer_info->last_name);
            }
            if($value->record_consume_ref_name == 'transaction_list')
            {
                $data['_item_product_code'][$key]->used_by = 'Used By SLOT NUMBER-'.strtoupper($value->slot_no);
                // if(!$value->slot_no)
                // {
                $data['_item_product_code'][$key]->used_by = Transaction::get_customer_name_transaction($value->record_consume_ref_id, $this->user_info->shop_id);
                // }
            }

            $released                                      = DB::table("tbl_release_product_code")->where("record_log_id", $value->record_log_id)->count();
            $distributed                                   = DB::table("tbl_distribute_product_code")->where("record_log_id", $value->record_log_id)->count();
            $data['_item_product_code'][$key]->released    = $released;
            $data['_item_product_code'][$key]->distributed = $distributed;
            
        }
        return view("member.mlm_code_v2.product_code_table",$data);
    }
    public function print_codes(Request $request)
    {
        $data['shop_id'] = $this->user_info->shop_id;
        $column[0]['name'] = 'Serial Code';
        $column[0]['code'] = 'pin_num';
        $column[0]['status'] = 'true';

        $column[1]['name'] = 'Activation';
        $column[1]['code'] = 'activation';
        $column[1]['status'] = 'true';

        $column[2]['name'] = 'Membership';
        $column[2]['code'] = 'membership';
        $column[2]['status'] = 'true';

        $column[3]['name'] = 'Item name';
        $column[3]['code'] = 'membership_kit';
        $column[3]['status'] = 'true';

        $data['columns'] = $column;
        $data['type'] = $request->type;

        Item::get_filter_type(5);
        $data["_item_kit"] = Item::get($this->user_info->shop_id);
        Item::get_filter_type(1);
        $data["_items"] = Item::get($this->user_info->shop_id);
        if($this->user_info->shop_id == 1)
        {
            $data["_items"] = Item::get_per_warehouse($this->user_info->shop_id, Warehouse2::get_current_warehouse($this->user_info->shop_id));
        }
        if($this->user_info->shop_id == 5)
        {
            $data['from'] = Item::get_last_print();
        }
        $data["_membership"] = MLM2::membership($this->user_info->shop_id);

        return view("member.mlm_code_v2.print_code_columns",$data);
    }
    public function print_codes_submit(Request $request)
    {
        $r['pin_num']        = $request->pin_num ? '' : 'hidden';
        $r['activation']     = $request->activation ? '' : 'hidden';
        $r['membership']     = $request->membership ? '' : 'hidden';
        $r['membership_kit'] = $request->membership_kit ? '' : 'hidden';
        $rt = serialize($r); 

        return Redirect::to('/member/mlm/print?t='.$request->type.'&Y='.$rt.'&status='.$request->status.'&print_range_to='.$request->print_range_to.'&print_range_from='.$request->print_range_from.'&membership='.$request->membership.'&membership_kit='.$request->membership_kit.'&item_id='.$request->item_id.'&type='.$request->barcode_type.'&print_type='.$request->print_code_as);
    }
    public function print(Request $request)
    {
        $data['on_show'] = unserialize($request->Y);
        $data['type'] = $request->type;
        $take = $request->print_range_from - $request->print_range_to;

        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['shop_name']  = $this->user_info->shop_key; 
        $data['head_title']  = 'Membership Code'; 
        $data['now']        = Carbon::now()->format('l F j, Y h:i:s A');
        $data['_item_product_code'] = Item::get_all_item_record_log('', $request->status, 0, $request->item_id, $request->print_range_to, $take);
        if($request->t == 'membership_code')
        {
            $data['_item_product_code'] = Item::get_assembled_kit(0,$request->membership_kit,$request->membership,'',$request->status, 0, $request->print_range_to, $take, $request->print_range_from);
            if($data['type'] == 'register_form' && Item::getShopId() == 5)
            {
                Item::tag_as_printed($warehouse_id, $request->print_range_to, $request->print_range_from);
            }
        }

        $data['warehouse_data'] = Warehouse2::get_info($warehouse_id);
        if($request->print_type == 'excel')
        {
            $view = 'member.mlm_code_v2.print_code_excel';
            return Report::check_report_type($request->print_type, $view, $data, 'Membership_Code-'.Carbon::now());
        }
        else
        {
            $paper_size = null;
            $orientation = null;
            if($this->user_info->shop_id == 5)
            {
                if($request->type == "register_form")
                {
                    $paper_size = "a6";
                    $orientation = 'landscape';
                }
            }
            $pdf = view('member.mlm_code_v2.print_code_pdf', $data);
            return Pdf_global::show_pdf($pdf, $orientation, null, $paper_size);
        }

    }
    public function report_code(Request $request)
    {
        $data['action'] = '';
        $data['shop_name']  = $this->user_info->shop_key; 
        $code_type = $request->code_type;
        $data['head_title']  = ucwords(str_replace('_', ' ', $request->code_type)).' Report'; 
        $date['start']  = $request->from;
        $date['end']    = $request->to;
        $period         = $request->report_period ? $request->report_period : 'all';
        $data['now']        = Carbon::now()->format('l F j, Y h:i:s A');
        $data["from"] = Report::checkDatePeriod($period,$date)['start_date'];
        $data["to"] = Report::checkDatePeriod($period,$date)['end_date'];
        $data["_warehouse"] = Warehouse2::get_all_warehouse($this->user_info->shop_id);

        $data['codes'] = Warehouse2::get_codes($request->warehouse_id, $data["from"], $data["to"], $request->transaction_type, $code_type);

        $data['warehouse_data'] = Warehouse2::get_info($request->warehouse_id);
        $report_type    = $request->report_type;
        $load_view      = $request->load_view;
        if($report_type && !$load_view)
        {
            $view =  'member.reports.output.output_report_code'; 
            return Report::check_report_type($report_type, $view, $data, 'Membership_Code_Report-'.Carbon::now());
        }
        else
        {
            return view('member.mlm_code_v2.report_code',$data);
        }
    }

    public function get_slot(Request $request)
    {
        return json_encode(DB::table("tbl_mlm_slot")->join('tbl_customer', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->where("tbl_mlm_slot.slot_owner", $request->customer_id)->get());
    }

    public function distribute()
    {
        $data["_customer"] = Customer::getAllCustomer(false, true);

        return view('member.mlm_code_v2.distribute', $data);
    }

    public function distribute_submit(Request $request)
    {
        
        
        $id               = $request->id;
        $exist            = Tbl_distribute_product_code::where("record_log_id", $id)->first();
        $customer_id      = $request->customer_id;
        $receipt_number   = $request->receipt_number;
        $amount           = $request->amount;
        $cellphone_number = $request->cellphone_number;
        $email            = $request->email;
        $slot_no          = $request->slot_no;
        $warehouse_id     = session('warehouse_id_1');
        $warehouse        = DB::table('tbl_warehouse')->where('warehouse_id', $warehouse_id)->first();
        if (!$exist) 
        {
            $record_log = Tbl_warehouse_inventory_record_log::where("record_log_id", $id)->first();

            if ($record_log) 
            {
                /* Use Product Code */
                $mlm_pin         = $record_log->mlm_pin;
                $mlm_activation  = $record_log->mlm_activation;
                $slot_id         = Tbl_mlm_slot::where('slot_no', $slot_no)->where('slot_owner', $customer_id)->value('slot_id');
                $shop_id         = $this->user_info->shop_id;
                $consume['name'] = 'customer_product_code';
                $consume['id']   = $customer_id;
                $val             = Warehouse2::consume_product_codes($shop_id, $mlm_pin, $mlm_activation, $consume);
                
                if(is_numeric($val))
                {
                    MLM2::purchase($shop_id, $slot_id, $val);
                    $return['status']        = 'success';
                    $return['call_function'] = 'success_used';


                    $item = Tbl_warehouse_inventory_record_log::where('mlm_activation',$mlm_activation)
                                                         ->where('mlm_pin',$mlm_pin)
                                                         ->first();
                    
                    $item_token = Tbl_item_token::where('item_id',$item->record_item_id)->first();

                    if($item_token)
                    {            
                        $token_log['shop_id']                = $shop_id;
                        $token_log['token_log_slot_owner']   = $customer_id;
                        $token_log['token_log_date_created'] = Carbon::now();
                        $token_log['token_id']               = $item_token->token_id;
                        $token_log['amount']                 = $item_token->amount;

                        Tbl_item_token_log::insert($token_log);
                    }

                    /* Insert Product Log */
                    $insert["customer_id"]                  = $customer_id;
                    $insert["record_log_id"]                = $id;
                    $insert["receipt_number"]               = $receipt_number;
                    $insert["amount"]                       = $amount;
                    $insert["cellphone_number"]             = $cellphone_number;
                    $insert["email"]                        = $email;
                    $insert["distribute_product_code_date"] = Carbon::now();
                    $insert["user_id"]                      = $this->user_info->user_id;

                    Tbl_distribute_product_code::insert($insert);

                    /* Send SMS and E-mail */
                    $code = DB::table("tbl_warehouse_inventory_record_log")->where("record_log_id", $id)->first();
                    
                    if ($code) 
                    {
                        $customer            = DB::table("tbl_customer")->where("customer_id", $customer_id)->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->join('tbl_membership', 'tbl_mlm_slot.slot_membership', '=', 'tbl_membership.membership_id');
                        $repurchase_cashback = DB::table('tbl_mlm_slot_points_log')->where('points_log_complan', 'REPURCHASE_CASHBACK')->where('points_log_slot', $slot_id)->sum('points_log_points');
                        $item_points         = MLM2::item_points($shop_id, $code->record_item_id, $code->mlm_slot_id_created)["REPURCHASE_CASHBACK"];

                        $repurchase_points = Tbl_mlm_item_points::where('item_id', $code->record_item_id)->where('membership_id', 1)->first();
                        $repurchase_points_total = DB::table('tbl_mlm_slot_points_log')->where('points_log_complan', 'REPURCHASE_POINTS')->where('points_log_slot', $slot_id)->sum('points_log_points');

                        $privilegecard = $customer->where('tbl_membership.membership_id', 1)->first();
                        //privilegecardholder
                        if($privilegecard)
                        {
                            $text_message        = "Hi " . ($customer ? ucwords(strtolower($privilegecard->first_name)) : '') . "! You earned P". number_format($repurchase_points->REPURCHASE_POINTS, 2) ." Points from your purchase at ".$warehouse->warehouse_name. ". Your total points now is P" . number_format($repurchase_points_total, 2) . ". Congratulations!";

                            $result              = Sms::SendSingleText($cellphone_number, $text_message, "", null);
                            
                            
                            $sponsor = $privilegecard->slot_sponsor;

                            $mail_recipient = DB::table('tbl_mlm_slot')->join('tbl_customer', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->where('tbl_mlm_slot.slot_id', $sponsor)->first();

                            $sponsor_cashback = DB::table('tbl_mlm_slot_points_log')->where('points_log_complan', 'UNILEVEL_CASHBACK_POINTS')->where('points_log_Sponsor', $slot_id)->first();

                            $sponsor_cashback_total = DB::table('tbl_mlm_slot_points_log')->where('points_log_complan', 'REPURCHASE_CASHBACK')->where('points_log_slot', $sponsor)->sum('points_log_points');


                            $email_content["subject"] = "Reward Code Distribute";

                            $email_content["content"] = "Hi " . ($mail_recipient ? ucwords(strtolower($mail_recipient->first_name)) : '') . "! You earned P". number_format($sponsor_cashback->points_log_points, 2) ." Cashback from ". ucwords(strtolower($privilegecard->first_name))." ".ucwords(strtolower($privilegecard->last_name)). " who purchased at ". $warehouse->warehouse_name." Your total Cashback is P" . number_format($sponsor_cashback_total, 2) . ". Congratulations!";


                            $return_mail = Mail_global::send_email(null, $email_content, Customer::getShopId(), $mail_recipient);

                        }
                        //vip
                        else
                        {
                            $vip = DB::table("tbl_customer")->where("customer_id", $customer_id)->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->join('tbl_membership', 'tbl_mlm_slot.slot_membership', '=', 'tbl_membership.membership_id')->first();
                            
                            $repurchase_cashback_points = DB::table('tbl_mlm_slot_points_log')->where([['points_log_slot', $vip->slot_id],['points_log_Sponsor', $vip->slot_id],['points_log_complan', 'REPURCHASE_CASHBACK']])->orderBy('points_log_id', 'DESC')->first();
                            $repurchase_cashback_total = DB::table('tbl_mlm_slot_points_log')->where([['points_log_slot', $vip->slot_id],['points_log_Sponsor', $vip->slot_id],['points_log_complan', 'REPURCHASE_CASHBACK']])->sum('points_log_points');

                            $text_message        = "Hi " . ($vip ? ucwords(strtolower($vip->first_name)) : '') . "! You earned P". number_format($repurchase_cashback_points->points_log_points, 2) ." Cashback from your purchase at ". $warehouse->warehouse_name." Your total Cashback is P" . number_format($repurchase_cashback_total, 2) . ". Congratulations!";
                            $result              = Sms::SendSingleText($cellphone_number, $text_message, "", null);
                        }
                        
                    }

                    $response["response_status"] = "success";
                }
                else
                {
                    $response['response_status'] = 'error';
                    $response['message']         = $val;
                }
            }
            else
            {
                $response["response_status"] = "error";
                $response["message"]         = "This product code doesn't exist.";
            }
        }
        else
        {
            $response["response_status"] = "error";
            $response["message"]         = "This product code is already distributed.";
        }

        return json_encode($response);
    }

    public function release()
    {
        $data["_customer"] = Customer::getAllCustomer(false, true);

        return view('member.mlm_code_v2.release', $data);
    }

    public function release_submit(Request $request)
    {
        $id    = $request->id;
        $exist = Tbl_release_product_code::where("record_log_id", $id)->first();

        if (!$exist) 
        {
            $customer_id      = $request->customer_id;
            $receipt_number   = $request->receipt_number;
            $amount           = $request->amount;
            $cellphone_number = $request->cellphone_number;
            $email            = $request->email;

            $insert["customer_id"]               = $customer_id;
            $insert["record_log_id"]             = $id;
            $insert["receipt_number"]            = $receipt_number;
            $insert["amount"]                    = $amount;
            $insert["cellphone_number"]          = $cellphone_number;
            $insert["email"]                     = $email;
            $insert["release_product_code_date"] = Carbon::now();
            $insert["user_id"]                   = $this->user_info->user_id;

            Tbl_release_product_code::insert($insert);

            $update['released'] = 1;
            Tbl_warehouse_inventory_record_log::where('record_log_id', $id)->update($update);

            /* Send SMS and E-mail */
            $code = DB::table("tbl_warehouse_inventory_record_log")->where("record_log_id", $id)->first();

            if ($code) 
            {
                $text_message = "PIN: " . $code->mlm_pin . " ACTIVATION: " . $code->mlm_activation;
                $result = Sms::SendSingleText($cellphone_number, $text_message, "", null);

                $email_content["subject"] = "Reward Code Release";
                $email_content["content"] = "PIN: " . $code->mlm_pin . "</br> ACTIVATION: " . $code->mlm_activation;

                $return_mail = Mail_global::send_email(null, $email_content, Customer::getShopId(), $email);
            }

            $response["response_status"] = "success";
        }
        else
        {
            $response["response_status"] = "error";
            $response["message"]         = "This product code is already released.";
        }

        return json_encode($response);
    }
    public function set_as_printed(Request $request)
    {
        
        Item::set_as_printed($request->printed);

        return  redirect('/member/mlm/product_code2');
    }

    public function print_codes_report()
    {
        $data['_released'] = Item::get_all_item_record_log('', "released");
        $data['_reserved'] = Item::get_all_item_record_log('', "reserved");
        $data['_blocked'] = Item::get_all_item_record_log('', "block");
        $data['_used'] = Item::get_all_item_record_log('', "used");
        $data['_sold'] = Item::get_all_item_record_log('', "sold");
        $data['_printed'] = Item::get_all_item_record_log('', "printed");
        
        $data['_distributed'] = Item::get_all_item_record_log('', "distributed");
        $data['_unused'] = Item::get_all_item_record_log('','');

        Excel::create('Codes Report', function($excel) use ($data)
        {
            foreach($data as $key => $value)
            {
                $data_container["data"] = $value;
                $excel->sheet( str_replace('_', " ", $key) .' codes', function($sheet) use ($data_container)
                {
                    $sheet->setOrientation('landscape');
                    $sheet->loadView('member.mlm_code_v2.product_code_excel_table', $data_container);
                   
                });
            }
        })->download('xlsx');

        return view('member.mlm_code_v2.product_code');
    }
}