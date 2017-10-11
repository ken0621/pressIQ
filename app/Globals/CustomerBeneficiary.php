<?php
namespace App\Globals;

use App\Models\Tbl_customer_beneficiary;
use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * 
 *
 * @author Arcylen
 */

class CustomerBeneficiary
{
	public static function create($customer_id , $data)
	{
		$check = Tbl_customer_beneficiary::where('customer_id',$customer_id)->get();
		$return = null;
		if($check)
		{
			$return = Tbl_customer_beneficiary::where('customer_id',$customer_id)->update($data);
		}
		else
		{	
			$data['customer_id'] = $customer_id;
			dd($data);
			$return = Tbl_customer_beneficiary::insertGetId($data);			
		}
	}
}