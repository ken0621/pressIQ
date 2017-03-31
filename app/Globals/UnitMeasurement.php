<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_item;
use App\Models\Tbl_user;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_settings;
use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_unit_measurement_multi;
use DB;
use Carbon\Carbon;
use Session;
class UnitMeasurement
{

    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function load_one_um($um_id)
    {
        return Tbl_unit_measurement::multi()->where("um_shop", UnitMeasurement::getShopId())
                                    ->where("um_id", $um_id)
                                    ->where("um_archived",0)
                                    ->get();
    }

    public static function load_um_multi()
    {
        return Tbl_unit_measurement::multi()->where("um_shop", UnitMeasurement::getShopId())
                                    ->where("um_archived",0)
                                    ->get();
    } 
    public static function um_qty($um_id)
    {
        $um_info = UnitMeasurement::um_info($um_id);
        $return_qty = 1;
        if($um_info != null)
        {
            $return_qty = $um_info->unit_qty;
        }
        return $return_qty;
    }
    public static function update_um($um_id,$item_name,$item_id)
    {
        if($um_id != null)
        {
            $chk = Tbl_unit_measurement::where("um_id",$um_id)->first();

            $old_um = Tbl_unit_measurement::where("um_id",$chk->parent_basis_um)->first();
            if($old_um)
            {
                $up["um_name"] = $old_um->um_name."(".$item_name.")";
                $up["um_item_id"] = $item_id;

                Tbl_unit_measurement::where("um_id",$um_id)->update($up);                
            }
        }
        Session::forget("um_id");   
    }
    public static function um_convert($qty, $um_base_id = "")
    {
        $um_base = Tbl_unit_measurement_multi::where("multi_um_id",$um_base_id)->where("is_base",1)->first();
        if($um_base != null)
        {
            $return = $qty." ".$um_base->multi_abbrev;
        }
        else
        {
            $return = $qty." PC";
        }

        return $return;
    }
    public static function um_view($qty, $um_base_id = "", $um_issued_id = "")
    {
        // if($um_issued_id == "")
        // {
        //     $um_issued_id = $um_base_id;
        // }
        
        $um_issued = Tbl_unit_measurement_multi::where("multi_id",$um_issued_id)->first();
        $um_base = Tbl_unit_measurement_multi::where("multi_um_id",$um_base_id)->where("is_base",1)->first();
        if($um_base_id == $um_issued_id)
        {
            if($um_base != null || $um_issued != null)
            {
                $return = $qty." ".$um_base->multi_abbrev;
            }
            else
            {
                $return = $qty == 0 ? 1 : $qty." PC";
            }
        }
        else if($um_issued != null && $um_base != null )
        {
            $issued_um_qty = 1;
            $base_um_qty = 1;
            if($um_issued != null)
            {
                $issued_um_qty = $um_issued->unit_qty;
            }
            if($um_base != null)
            {
                $base_um_qty = $um_base->unit_qty;
            }

            $issued_um = floor($qty / $issued_um_qty);
            $each = (($qty / $issued_um_qty) - floor($qty / $issued_um_qty)) * $issued_um_qty;
            // dd($um_base);
            $return = $issued_um." ".$um_issued->multi_abbrev." & ".$each." ".$um_base->multi_abbrev;
        }
        else
        {
            $return = $qty." PC";
        }

        if($um_issued != null)
        {     
            if($um_issued->is_base == 1)
            {
                $return = $qty." ".$um_issued->multi_abbrev;
            }
        }

        return $return;
    }
    public static function load_um()
    {
        return Tbl_unit_measurement::where("um_shop", UnitMeasurement::getShopId())
                                    ->multi()
                                    ->where("tbl_unit_measurement_multi.is_base",1)
                                    ->groupBy("um_id")
                                    ->where("um_archived",0)
                                    ->where("parent_basis_um",0)
                                    ->get();
    }

    public static function select_um($um_id = 0, $return = 'array')
    {
    	$data = Tbl_unit_measurement_multi::where("multi_um_id",$um_id)->get();

    	if($return == "json")
    	{
    		$data = json_encode($data);
    	}
    	return $data;
    }

    public static function um_info($multi_id)
    {
        $unit_m = Tbl_unit_measurement_multi::where("multi_id",$multi_id)->first();
        
        return $unit_m;
    }
    public static function select_um_array($multi_id = 0, $return = 'array')
    {
    	if(is_numeric($multi_id))
        {
            //unit_measurement_multi
            //multi_id
            $um_id = Tbl_unit_measurement_multi::where("multi_id",$multi_id)->pluck("multi_um_id");
            $data = Tbl_unit_measurement::multi()->where("um_id",$um_id)->where("um_archived",0)->get();
        }
        else
        {
            //unit_measurement 
            //um_id
            $data = Tbl_unit_measurement::multi()->where("um_id",str_replace("_um", "", $multi_id))->where("um_archived",0)->get();
        }           

    	if($return == "json")
    	{
    		$data = json_encode($data);
    	}
    	return $data;
    }
}