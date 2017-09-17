<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\MLM2;
use App\Globals\Warehouse2;
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
        $data['_assembled_item_kit'] = Item::get_assembled_kit(0, $request->item_kit_id, $request->item_membership_id, $request->search_keyword, $request->status);
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
        $data['_item_product_code'] = Item::get_all_item_record_log($request->search_keyword, $request->status);
        return view("member.mlm_code_v2.product_code_table",$data);
    }
}