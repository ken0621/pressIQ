<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Tbl_inventory_slip;
class InventoryLogController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouse_id = $this->current_warehouse->warehouse_id;
        $data["_slip"] = Tbl_inventory_slip::where("warehouse_id",$warehouse_id)->where("inventory_slip_shop_id",$this->user_info->shop_id)->orderBy("inventory_slip_date","DESC")->get();
        
        foreach ($data["_slip"] as $key => $value) 
        {
            if($value->inventory_reason == "destination")
            {
                $data["_slip"][$key]->inventory_reason = "refill";
            }
        }
        return view("member.warehouse.inventory_log.general_inventory_log",$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
