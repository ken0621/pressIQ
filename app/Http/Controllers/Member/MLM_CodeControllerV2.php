<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\MLM2;
use App\Globals\Warehouse2;
use App\Globals\Pdf_global;
use App\Globals\Customer;

use App\Globals\BarcodeGenerator;
use Redirect;
use Illuminate\Http\Request;

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

            foreach ($record_log_id as $key => $value) 
            {
                Item::disassemble_membership_kit($value);
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
            $record_log_id = $request->record_log_id;

            $update['record_consume_ref_name'] = NULL;
            if($status == 'reserved' || $status == 'block')
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
            }
        }

        return view("member.mlm_code_v2.product_code_table",$data);
    }
    public function print_codes(Request $request)
    {
        $column[0]['name'] = 'PIN No';
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

        return Redirect::to('/member/mlm/print?t='.$request->type.'&Y='.$rt.'&status='.$request->status.'&print_limit='.$request->print_limit.'&membership='.$request->membership.'&membership_kit='.$request->membership_kit.'&item_id='.$request->item_id.'&type='.$request->barcode_type);
    }
    public function print(Request $request)
    {
        $data['on_show'] = unserialize($request->Y);
        $data['type'] = $request->type;
        $data['_item_product_code'] = Item::get_all_item_record_log('', $request->status, $request->print_limit, $request->item_id);
        if($request->t == 'membership_code')
        {
            $data['_item_product_code'] = Item::get_assembled_kit(0,$request->membership_kit,$request->membership,'',$request->status, $request->print_limit);
        }
        $pdf = view('member.mlm_code_v2.print_code_pdf', $data);
        return Pdf_global::show_pdf($pdf);
    }
}