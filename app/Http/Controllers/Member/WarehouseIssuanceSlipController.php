<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
