<?php

namespace App\Http\Controllers\Member;

use Request;
use Session;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Tbl_category;
use App\Globals\Item;
use App\Models\Tbl_merchant_school;
class BeneficiaryController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [];
        $shop_id = $this->user_info->shop_id;
        $data['_item'] = Item::get_all_category_item();
        return view('member.merchant_school.index', $data);
    }
    public function get()
    {
        $shop_id = $this->user_info->shop_id;
        $data['items'] = Tbl_merchant_school::where('merchant_school_shop', $shop_id)
        ->join('tbl_item', 'tbl_item.item_id', '=', 'tbl_merchant_school.merchant_item_id')
        ->get();
        return view('member.merchant_school.get', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return $_POST;

        $shop_id = $this->user_info->shop_id;
        $item_id = Request::input('item_id');

        if($item_id != null)
        {
            $count = Tbl_merchant_school::where('merchant_school_shop', $shop_id)
            ->where('merchant_item_id', $item_id)
            ->count();
            if($count == 0)
            {
                $insert['merchant_school_shop'] = $shop_id;
                $insert['merchant_item_id'] = $item_id;
                Tbl_merchant_school::insert($insert);

                $data['status'] = 'success'; 
                $data['message'] = 'Item Added to list';
            }
            else
            {
                $data['status'] = 'error';
                $data['message'] = 'Item already added';
            }
        }
        else
        {
            $data['status'] = 'error';
            $data['message'] = 'Invalid Item';
        }

        return json_encode($data);
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
    public function destroy()
    {
        //
        $shop_id = $this->user_info->shop_id;
        $item_id = Request::input('item_id');

        Tbl_merchant_school::where('merchant_school_shop', $shop_id)
        ->where('merchant_item_id', $item_id)
        ->delete();

        $data['status'] = 'success';
        $data['message'] = 'Item removed from list';

        return json_encode($data);
    }
}
