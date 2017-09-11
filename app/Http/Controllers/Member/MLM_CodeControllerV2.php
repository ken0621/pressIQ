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
    public function membership_code_assemble(Request $request)
    {
        if($request->isMethod("post"))
        {
            $item_id            = $request->item_id;
            $quantity           = ($request->quantity <= 0 ? 1 : $request->quantity);

            
            
            $response["status"] = "success";
            $response["call_function"] = "membership_code_assemble_success";
            $response["message"] = "<b>3 MEMBERSHIP KIT</b> CREATED";
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
    public function index()
    {
        $data['_item_product_code'] = Item::get_all_item_record_log();
        return view("member.mlm_code_v2.product_code",$data);
    }
}