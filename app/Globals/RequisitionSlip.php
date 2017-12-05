<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_requisition_slip_item;

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
	public static function create($shop_id, $user_id, $input)
	{
		$return = null;
		$insert['shop_id'] = $shop_id;
		$insert['user_id'] = $user_id;
		$insert['requisition_slip_number'] = $input->requisition_slip_number;
		$insert['requisition_slip_remarks'] = $input->requisition_slip_remarks;
		$insert['requisition_slip_date_created'] = Carbon::now();

	    $rule["requisition_slip_number"] = "required";
        $rule["requisition_slip_remarks"] = "required";

        $validator = Validator::make($insert, $rule);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
            {
                $return .= $message;
            }
        }
        if(count($input->rs_item_id) > 0)
        {
        	
        }

        if(!$return)
        {
        	$rs_id = Tbl_requisition_slip::insertGetId($insert);

        }

		if(is_numeric($return))
		{

		}
		else
		{
			
		}

        return $return;
	}
}