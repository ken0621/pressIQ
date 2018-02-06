<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_requisition_slip_item;
use Request;
use Carbon\Carbon;
use DB;
use Validator;

/**
 * Requisition Slip
 *
 * @author Arcylen
 */

class RequisitionSlip
{
    public static function get($shop_id, $status = null, $paginate = null, $search_keyword = null)
    {
        $data = Tbl_requisition_slip_item::PRInfo()->where('shop_id', $shop_id);
        
        if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("rs_id", "LIKE", "%$search_keyword%");
                $q->orWhere("rs_item_amount", "LIKE", "%$search_keyword%");
            });
        }

        if($status != 'all')
        {
            $data = $data->where('requisition_slip_status',$status);
        }
        if($paginate)
        {
            $data = $data->paginate($paginate);
        }
        else
        {
            $data = $data->get();
        }

        return $data;
    }
    public static function get_slip($shop_id, $slip_id)
    {
        return Tbl_requisition_slip::where('shop_id',$shop_id)->where('requisition_slip_id', $slip_id)->first();
    }
    public static function get_slip_item($slip_id)
    {
        return Tbl_requisition_slip_item::vendor()->item()->where('rs_id', $slip_id)->get();
    }
    public static function update_status($shop_id, $slip_id, $update)
    {
        return Tbl_requisition_slip::where('shop_id',$shop_id)->where('requisition_slip_id', $slip_id)->update($update);
    }
    public static function countTransaction($shop_id, $vendor_id)
    {
        /*$count_so = Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->count();
        $count_pr = Tbl_requisition_slip_item::PRInfo('shop_id',$shop_id)->where("requisition_slip_status","closed")->count();
        
        $return = $count_so + $count_pr;*/
        return Tbl_requisition_slip_item::PRInfo('shop_id',$shop_id)->where("requisition_slip_status","closed")->count();
    }
	public static function create($shop_id, $user_id, $input, $transaction_type ='')
	{
        $btn_action = Request::input('button_action');

		$validate = null;
		$insert['shop_id']                  = $shop_id;
		$insert['user_id']                  = $user_id;
		$insert['transaction_refnum']       = $input->requisition_slip_number;
		$insert['requisition_slip_remarks'] = $input->requisition_slip_remarks;
		$insert['requisition_slip_date_created'] = Carbon::now();

        if($transaction_type)
        {
            $validate .= AccountingTransaction::check_transaction_ref_number($shop_id, $insert['transaction_refnum'], 'purchase_requisition');
        }
        
	    $rule["transaction_refnum"] = "required";
        $rule["requisition_slip_remarks"] = "required";

        $validator = Validator::make($insert, $rule);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
            {
                $validate .= $message;
            }
        }
        $_item = null;
        $ctr = 0;
        foreach ($input->rs_item_id as $key1 => $value) 
        {
            if($value)
            {
                $ctr++;
                if($input->rs_item_qty[$key1] <= 0)
                {
                    $validate .= 'The quantity of <b>'.Item::info($value)->item_name.'</b> is less than zero.';
                }

                if($input->rs_vendor_id[$key1] =="" )
                {
                    $validate .= 'Please select vendor.';
                }
            }
        }

        if($ctr <= 0)
        {
            $validate .= "Please insert Item";
        }

        if(!$validate)
        {
        	$rs_id = Tbl_requisition_slip::insertGetId($insert);


            foreach ($input->rs_item_id as $key => $value) 
            {
                if($value)
                {
                    $_item[$key]['rs_id']               = $rs_id;
                    $_item[$key]['rs_item_id']          = $value;
                    $_item[$key]['rs_item_description'] = $input->rs_item_description[$key];
                    $_item[$key]['rs_item_um']          = $input->rs_item_um[$key];
                    $_item[$key]['rs_item_qty']         = $input->rs_item_qty[$key];
                    $_item[$key]['rs_item_rate']        = $input->rs_item_rate[$key];
                    $_item[$key]['rs_item_amount']      = $input->rs_item_amount[$key];
                    $_item[$key]['rs_vendor_id']        = $input->rs_vendor_id[$key];
                }
            }
            if(count($_item) > 0)
            {
                Tbl_requisition_slip_item::insert($_item);
            }
            $validate = $rs_id;
        }
        
		if(is_numeric($validate))
		{   
            $return['status'] = 'success';
            $return['call_function'] = 'success_create_rs';

            if($btn_action == "sclose")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition';
            }
            elseif($btn_action == "sedit")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/create?id='.$validate;
            }
            elseif($btn_action == "snew")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/create';
            }
            elseif($btn_action == "sprint")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/print/'.$validate;
            }

		}
		else
		{
            $return['status'] = 'error';
            $return['status_message'] = $validate;			
		}

        return $return;
	}
    public static function update($shop_id, $user_id, $input, $transaction_type ='')
    {
        $btn_action = Request::input('button_action');
        $pr_id = Request::input('pr_id');

        $validate = null;
        $insert['shop_id']                  = $shop_id;
        $insert['user_id']                  = $user_id;
        $insert['requisition_slip_number']  = $input->requisition_slip_number;
        $insert['requisition_slip_remarks'] = $input->requisition_slip_remarks;
        $insert['requisition_slip_date_created'] = Carbon::now();

        $rule["requisition_slip_number"] = "required";
        $rule["requisition_slip_remarks"] = "required";

        $validator = Validator::make($insert, $rule);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
            {
                $validate .= $message;
            }
        }
        $_item = null;
        $ctr = 0;
        foreach ($input->rs_item_id as $key1 => $value) 
        {
            if($value)
            {
                $ctr++;
                if($input->rs_item_qty[$key1] <= 0)
                {
                    $validate .= 'The quantity of <b>'.Item::info($value)->item_name.'</b> is less than zero.';
                }

                if($input->rs_vendor_id[$key1] =="" )
                {
                    $validate .= 'Please select vendor.';
                }
            }
        }

        if($ctr <= 0)
        {
            $validate .= "Please insert Item";
        }

        if(!$validate)
        {
            Tbl_requisition_slip::where('requisition_slip_id', $pr_id)->update($insert);
            Tbl_requisition_slip_item::where('rs_id', $pr_id)->delete();


            foreach ($input->rs_item_id as $key => $value) 
            {
                if($value)
                {
                    $_item[$key]['rs_id']               = $pr_id;
                    $_item[$key]['rs_item_id']          = $value;
                    $_item[$key]['rs_item_description'] = $input->rs_item_description[$key];
                    $_item[$key]['rs_item_um']          = $input->rs_item_um[$key];
                    $_item[$key]['rs_item_qty']         = $input->rs_item_qty[$key];
                    $_item[$key]['rs_item_rate']        = $input->rs_item_rate[$key];
                    $_item[$key]['rs_item_amount']      = $input->rs_item_amount[$key];
                    $_item[$key]['rs_vendor_id']        = $input->rs_vendor_id[$key];
                }
            }
            if(count($_item) > 0)
            {
                Tbl_requisition_slip_item::insert($_item);
            }
            $validate = $pr_id;
        }
        
        if(is_numeric($validate))
        {   
            $return['status'] = 'success';
            $return['call_function'] = 'success_create_rs';

            if($btn_action == "sclose")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition';
            }
            elseif($btn_action == "sedit")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/create?id='.$validate;
            }
            elseif($btn_action == "snew")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/create';
            }
            elseif($btn_action == "sprint")
            {
                $return['status_redirect'] = '/member/transaction/purchase_requisition/print/'.$validate;
            }

        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;          
        }

        return $return;
    }

}