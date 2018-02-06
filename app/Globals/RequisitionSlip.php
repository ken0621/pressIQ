<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_requisition_slip_item;
use App\Models\Tbl_purchase_order_line;
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
    /*public static function get_vendor_per_item($pr_id)
    {
        $data = Tbl_requisition_slip::where('requisition_slip_id',$pr_id)->get();
        dd($data);
    }*/
    public static function get($shop_id, $status = null, $paginate = null, $search_keyword = null)
    {
        $data = Tbl_requisition_slip::where('shop_id', $shop_id);
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
                //$po = Tbl_purchase_order::insert($_po);
            }
            $total_amount = collect($_item)->sum('rs_item_amount'); 
            $insert['total_amount'] = $total_amount;

            Tbl_requisition_slip::where('requisition_slip_id', $rs_id)->update($insert);

            if(count($_item) > 0)
            {
                Tbl_requisition_slip_item::insert($_item);
            }

            $po_line = null;
            $po = null;
            foreach ($input->rs_vendor_id as $key => $value)
            {
                $po[$value] = $value;

                //$data= Tbl_requisition_slip_item::where('rs_id', $rs_id)->where('rs_vendor_id', $value)->get();

                //$po[$data]['item'] = $input->rs_item_id;

                /*$po[$value] = $value;
                $ins['po_vendor_id'] = $value;
                $ins['transaction_refnum'] = $insert['transaction_refnum'];
                $ins['date_created'] = Carbon::now();
                die(var_dump($ins));
                $po_id =Tbl_purchase_order::insertGetId($ins);*/
                
                $data_line = Tbl_requisition_slip_item::where('rs_id', $rs_id)->where('rs_vendor_id', $value)->get();

                foreach ($data_line as $key_line => $value_line)
                {
                    //die(var_dump($value));
                    $po_line[$key_line]['poline_po_id']       = $po_id;
                    $po_line[$key_line]['poline_item_id']     = $value_line->rs_item_id;
                    $po_line[$key_line]['poline_description'] = $value_line->rs_item_description;
                    $po_line[$key_line]['poline_orig_qty']    = $value_line->rs_item_qty;
                    $po_line[$key_line]['poline_qty']         = $value_line->rs_item_qty;
                    $po_line[$key_line]['poline_rate']        = $value_line->rs_item_rate;
                    $po_line[$key_line]['poline_amount']      = $value_line->rs_item_amount;
                } 

                
                Tbl_purchase_order_line::insert($po_line);
            }
            //die(var_dump($data));

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
        $insert['transaction_refnum']  = $input->requisition_slip_number;
        $insert['requisition_slip_remarks'] = $input->requisition_slip_remarks;
        $insert['requisition_slip_date_created'] = Carbon::now();

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
        $_po = null;
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
            

            $total_amount = collect($_item)->sum('rs_item_amount'); 
            $insert['total_amount'] = $total_amount;

            Tbl_requisition_slip::where('requisition_slip_id', $pr_id)->update($insert);

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