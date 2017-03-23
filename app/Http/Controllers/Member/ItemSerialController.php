<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_warehouse_inventory;
use App\Globals\ItemSerial;
use App\Models\Tbl_item;
class ItemSerialController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($warehouse_id)
    {
        $data["_item_serial"] = Tbl_inventory_serial_number::item()->warehouse_inventory()->where("has_serial_number",1)->groupBy("tbl_item.item_id")->where("tbl_warehouse_inventory.warehouse_id",$warehouse_id)->where("tbl_item.shop_id",$this->user_info->shop_id)->get();
        foreach ($data["_item_serial"] as $key => $value) 
        {
            $data["_item_serial"][$key]->inventory_count = Tbl_warehouse_inventory::check_inventory_single($warehouse_id,$value->item_id)->pluck('inventory_count');
        }
        return view("member.item_serial.item_serial",$data);
    }
    public function view_serial($item_id)
    {
        $data["item_name"] = Tbl_item::where("item_id",$item_id)->first();
        $data["_item_serial"] = ItemSerial::getItemSerial($item_id);

        return view("member.item_serial.list_serial",$data);
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
