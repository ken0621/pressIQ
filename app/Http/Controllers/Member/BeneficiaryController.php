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
    public function get_table()
    {
        $data['items_s'] = DB::table('tbl_merchant_school_item')
        ->join('tbl_item', 'tbl_item.item_id', '=', 'tbl_merchant_school_item.merchant_item_item_id')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_merchant_school_item.merchant_item_customer_id');

        $s_status = Request::input('s_status');
        $s_search_by = Request::input('s_search_by');
        $s_input = Request::input('s_input');
        if($s_status != null)
        {
            if($s_status != 'all')
            {
                $data['items_s'] = $data['items_s']->where('merchant_item_status', $s_status);
            }
        }
        if($s_search_by != null)
        {
            switch ($s_search_by) {
                case 'all':
                    break;
                case 'customer_name':
                    $data['items_s'] = $data['items_s']->where('first_name', 'like', '%' . $s_input . '%');
                    $data['items_s'] = $data['items_s']->orWhere('last_name', 'like', '%' . $s_input . '%');
                    break;  
                case 'order':
                    $data['items_s'] = $data['items_s']->where('merchant_item_ec_order_id', 'like', '%' . $s_input . '%');
                    break;   
                case 'code':
                    $data['items_s'] = $data['items_s']->where('merchant_item_code', 'like', '%' . $s_input . '%');
                    break;  
                case 's_id':
                    $data['items_s'] = $data['items_s']->where('merchant_school_s_id', 'like', '%' . $s_input . '%');
                    break;  
                case 's_name':
                    $data['items_s'] = $data['items_s']->where('merchant_school_s_name', 'like', '%' . $s_input . '%');
                    break;                 
                default:
                    break;
            }
        }
        $data['s_status'] = $s_status;
        $data['s_search_by'] = $s_search_by;
        $data['s_input'] = $s_input;
        $data['items_s'] = $data['items_s']->paginate(10);

        return view('member.merchant_school.table', $data);
    }
    public function mark_used()
    {
        $merchant_school_item_id = Request::input('merchant_school_item_id');
        $update['merchant_item_status'] = 2;

         DB::table('tbl_merchant_school_item')->where('merchant_school_item_id', $merchant_school_item_id)->update($update);

         $data['status'] = 'success'; 
         $data['message'] = 'Mark as Used';

         return json_encode($data);
    }
}
