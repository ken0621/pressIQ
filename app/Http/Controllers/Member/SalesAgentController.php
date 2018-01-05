<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Customer;
use App\Globals\Item;
use App\Globals\CommissionCalculator;
use App\Globals\SalesAgent;

use App\Models\Tbl_employee;
use App\Models\Tbl_position;
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
		Session::forget("import_coa_error");

		$value     = $request->value;
		$input     = $request->input;

		$ctr 	   		= $request->ctr;
		$data_length 	= $request->data_length;
		$error_data 	= $request->error_data;

		//die(var_dump($ctr));
		if($ctr != $data_length)
		{
			$agent_code		= isset($value["Agent Code"])			? $value["Agent Code"] : '' ;
			$first_name		= isset($value["First Name"])			? $value["First Name"] : '' ;
			$middle_name	= isset($value["Middle Name"])			? $value["Middle Name"] : '' ;
			$last_name		= isset($value["Last Name"])			? $value["Last Name"] : '' ;
			$position_code	= isset($value["Position Code"])		? $value["Position Code"] : '' ;
			$position		= isset($value["Position"])				? $value["Position"] : '' ;
			$com_percent	= isset($value["Commission Percent"])	? $value["Commission Percent"] : '' ;


			$position_id = null;
			if(!isset($position))
			{
				$position_id = Tbl_position::where("position_shop_id", $this->user_info->shop_id)->where("position_id", $position_code)->first();
			}

			$json = null;
			if(!$duplicate_position)
			{
				$insert_position['position_shop_id']   = $this->user_info->shop_id;
            	$insert_position['position_code'] 	   = $position_code;
            	$insert_position['position_name'] 	   = $position;
            	$insert_position['archived'] 		   = 0;
            	$insert_position['commission_percent'] = $com_percent;
            	$insert_position['position_created']   = Carbon::now();

            	$insert_agent['shop_id']   			= $this->user_info->shop_id;
	            $insert_agent['agent_code'] 		= $agent_code;
	        	$insert_agent['first_name'] 		= $first_name;
	        	$insert_agent['middle_name'] 		= $middle_name;
	        	$insert_agent['last_name'] 			= $last_name;
	        	$insert_agent['date_created'] 		= Carbon::now();

	        	$rules["position_name"] = 'required';

				$validator = Validator::make($insert_position, $rules);
				if ($validator->fails())
				{
					$json["status"] 	= "error";
					$json["message"]  	= $validator->errors()->first();
				}
				else
				{
					$position_id = Tbl_position::insertGetId($insert_position);  
		            $insert_agent['position_id'] = $position_id;
		            Tbl_employee::insert($insert_agent);

		            $json["status"]		= "success";
					$json["message"]	= "Success";
					$json["item_id"]	= $position_id;
				}
		        
			}
		}
		//die(var_dump($position_id));
		return $json;
	}

	/* Do not Remove */
	public function postUrl()
	{

	}
}