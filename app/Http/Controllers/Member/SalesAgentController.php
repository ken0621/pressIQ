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

	public function postAgentReadFile(Request $request, $position_id)
	{
		Session::forget("import_coa_error");

		$value     = $request->value;
		$input     = $request->input;

		$ctr 	   		= $request->ctr;
		$data_length 	= $request->data_length;
		$error_data 	= $request->error_data;

		if($ctr != $data_length)
		{
			$agent_code		= isset($value["Agent Code"])			? $value["Agent Code"] : '' ;
			$first_name		= isset($value["First Name"])			? $value["First Name"] : '' ;
			$middle_name	= isset($value["Middle Name"])			? $value["Middle Name"] : '' ;
			$last_name		= isset($value["Last Name"])			? $value["Last Name"] : '' ;
			$position_code	= isset($value["Position Code"])		? $value["Position Code"] : '' ;
			$position		= isset($value["Position"])				? $value["Position"] : '' ;
			$com_percent	= isset($value["Commission Percent"])	? $value["Commission Percent"] : '' ;

			
  			$insertposition['position_shop_id']   = $this->user_info->shop_id;
            $insertposition['position_code'] 	  = $position_code;
            $insertposition['position_name'] 	  = $position;
            $insertposition['archived'] 		  = 0;
            $insertposition['commission_percent'] = $com_percent;
            $insertposition['position_created']   = Carbon::now();

            die(var_dump($insertposition));
			
			$position_id = Tbl_position::insertGetId($insertposition);
			//die(var_dump($value));
			/*$insertagent['shop_id'] 		= $this->user_info->shop_id;
            $insertagent['agent_code'] 		= $agent_code;
            $insertagent['first_name'] 		= $first_name;
            $insertagent['middle_name'] 	= $middle_name;
            $insertagent['last_name'] 		= $last_name;
            $insertagent['position_id'] 	= $position_id;
            $insertagent['date_created'] 	= Carbon::now();			

            $agent_id = Tbl_employee::insertGetId($insertagent);*/
           
            //$position_id 	= Tbl_position::where('position_id', $position_id);


			
			
		}
		else
		{
			Session::put("import_coa_error", $error_data);
		}
	}

	/* Do not Remove */
	public function postUrl()
	{

	}
}