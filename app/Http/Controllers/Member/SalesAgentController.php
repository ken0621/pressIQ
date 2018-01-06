<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Customer;
use App\Globals\Item;
use App\Globals\CommissionCalculator;
use App\Globals\SalesAgent;

use App\Models\Tbl_employee;
use Carbon\Carbon;
use Validator;
use Session;
use Excel;
use URL;

class SalesAgentController extends Member
{
	/**
     * Display a listing of the resource.
     * @author ARCYLEN
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
    	$data['page'] = "Sales Agent List";
    	$data['_list'] = SalesAgent::get_list($this->user_info->shop_id, true);
    	return view('member.cashier.sales_agent.sales_agent_list',$data);
    }
    public function getAdd()
	{
		$data['page'] = '';
        $data["_position"] = SalesAgent::get_position($this->user_info->shop_id);
    	return view('member.cashier.sales_agent.sales_agent_add',$data);		
	}
	public function postAddSubmit(Request $request)
	{
		$ins['last_name'] = $request->last_name;
		$ins['first_name'] = $request->first_name;
		$ins['middle_name'] = $request->middle_name;
		$ins['position_id'] = $request->position;

		$id = SalesAgent::create($this->user_info->shop_id, $ins);

		if(is_numeric($id))
		{
			$return['status'] = 'success';
			$return['id'] = $id;
			$return['call_function'] = 'success_agent';
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = "Something wen't wrong.";
		}

		return json_encode($return);
	}
	public function getLoadAgent(Request $request)
	{		
        $data['_agent'] = SalesAgent::get_list($this->user_info->shop_id);
        return view('member.cashier.sales_agent.load_sales_agent',$data);
	}
	public function getViewTransaction(Request $request, $agent_id = 0)
	{
		if($agent_id != 0)
		{
			$data['_transaction'] = CommissionCalculator::per_agent_commission($agent_id);
			$data['agent'] = SalesAgent::info($this->user_info->shop_id, $agent_id);

			return view('member.cashier.sales_agent.sales_agent_transaction',$data);
		}
	}
	public function getInvoices(Request $request, $commission_id)
	{
		$data['_invoices'] = CommissionCalculator::per_commission_invoices($commission_id);
		$data['commission'] = CommissionCalculator::info($this->user_info->shop_id,$commission_id);
		
		return view('member.cashier.sales_agent.sales_agent_invoices',$data);
	}
	public function getImport()
	{
		return view('member.cashier.sales_agent.sales_agent_import');
	}
	public function getAgentTemplate()
	{
		Excel::create("AgentTemplate", function($excel)
		{
			// Set the title
		    $excel->setTitle('Digimahouse');

		    // Chain the setters
		    $excel->setCreator('DigimaWebSolutions')
		          ->setCompany('DigimaWebSolutions');

		    $excel->sheet('Template', function($sheet) {
		    	$header = [
		    				'Agent Code',
                        	'First Name',
                        	'Middle Name',
                        	'Last Name',
                        	'Position Code',
                        	'Position',
                        	'Commission Percent'
		    				];
		    	$sheet->freezeFirstRow();
		        $sheet->row(1, $header);
		    });


		})->download('csv');
	}

	public function postAgentReadFile(Request $request)
	{
		Session::forget("import_agent_error");

		$value     = $request->value;
		$input     = $request->input;

		//die(var_dump($value));
		$ctr 	   		= $request->ctr;
		$data_length 	= $request->data_length;
		$error_data 	= $request->error_data;

		if($ctr != $data_length)
		{
			$agent_code			= isset($value["Agent Code"])			? $value["Agent Code"] : '' ;
			$first_name			= isset($value["First Name"])			? $value["First Name"] : '' ;
			$middle_name		= isset($value["Middle Name"])			? $value["Middle Name"] : '' ;
			$last_name			= isset($value["Last Name"])			? $value["Last Name"] : '' ;
			$position_code		= isset($value["Position Code"])		? $value["Position Code"] : '' ;
			$position			= isset($value["Position"])				? $value["Position"] : '' ;
			$commission_percent	= isset($value["Commission Percent"])	? $value["Commission Percent"] : '' ;

			//die(var_dump($value));

			/* Validation */
			/*$duplicate_agent = null;
			$duplicate_position = null;
			if($first_name && $middle_name && $last_name)
			{
				$duplicate_agent	= Tbl_employee::where("shop_id", $this->user_info->shop_id)->where("first_name", $first_name)->where("middle_name", $middle_name)->where("last_name", $last_name)->first();
			}
			
			if(!$duplicate_agent)
			{
				$insertagent['shop_id'] 	 = $this->user_info->shop_id;
	            $insertagent['agent_code'] 	 = $agent_code;
	            $insertagent['first_name'] 	 = $first_name;
	            $insertagent['middle_name']  = $middle_name;
	            $insertagent['last_name'] 	 = $last_name;
	            $insertagent['created_date'] = Carbon::now();

	            $insertposition['position_code'] 	  = $position_code;
	            $insertposition['position_name'] 	  = $position;
	            $insertposition['commission_percent'] = $commission_percent;

	            $rules["first_name"] = 'required';
	            $rules["last_name"]  = 'required';

				$validator = Validator::make($insertagent, $rules);
				if ($validator->fails())
				{
					$json["status"] 	= "error";
					$json["message"]  	= $validator->errors()->first();
				}
				else
				{
					$agent_id = Tbl_employee::insertGetId($insertagent);
		            
		            $insertInfo['ven_info_vendor_id'] = $vendor_id;
		            Tbl_vendor_other_info::insert($insertInfo);


		            $json["status"]		= "success";
					$json["message"]	= "Success";
					$json["item_id"]	= $vendor_id;
	        	}
			}
			else
			{
				$json["status"]		= "error";
				$json["message"]	= "Duplicate Agent name";
			}*/

			$status_color 		= $json["status"] == 'success' ? 'green' : 'red';
			$json["tr_data"]	= "<tr>";
			$json["tr_data"]   .= "<td class='$status_color'>".$json["status"]."</td>";
			$json["tr_data"]   .= "<td nowrap>".$json["message"]."</td>";
			$json["tr_data"]   .= "<td nowrap>".$agent_code."</td>";
			$json["tr_data"]   .= "<td nowrap>".$first_name."</td>";
			$json["tr_data"]   .= "<td nowrap>".$middle_name."</td>";
			$json["tr_data"]   .= "<td nowrap>".$last_name."</td>";
			$json["tr_data"]   .= "<td nowrap>".$position_code."</td>";
			$json["tr_data"]   .= "<td nowrap>".$commission_percent."</td>";
			$json["tr_data"]   .= "</tr>";

			$json["value_data"] = $value;
			$length 			= sizeOf($json["value_data"]);

			foreach($json["value_data"] as $key=>$value)
			{
				$json["value_data"]['Error Description'] = $json["message"];
			}
		}
		else /* DETERMINE IF LAST IN CSV */
		{
			Session::put("import_agent_error", $error_data);
			$json["status"] = "end";
		}

        return json_encode($json);
	}

	/* Do not Remove */
	public function postUrl()
	{

	}
}