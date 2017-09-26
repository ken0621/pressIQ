<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;

class WarehouseIssuanceSlipController extends Member
{
    public function getIndex()
    {
    	$data['page'] = 'WIS';

    	return view('member.warehousev2.wis.wis_list',$data);
    }
    public function getCreate()
    {
    	$data['page'] = 'CREATE - WIS';

    	return view('member.warehousev2.wis.wis_create',$data);
    }
    public function getTableItem()
    {
        $data['page'] = 'Table Item';
        $data["cart_key"]   = $cart_key = Cart2::get_cart_key();
        $data["cart"]       = $_items = Cart2::get_cart_info();

        return view('member.warehousev2.wis.wis_table_item',$data);
    }
    public function getViewSerial()
    {

        return view('member.warehousev2.wis.wis_serial');
    }
    public function getConfirm()
    {

        return view('member.warehousev2.wis.wis_confirm');
    }
}
