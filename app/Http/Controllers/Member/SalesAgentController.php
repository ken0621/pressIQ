<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Customer;
use App\Globals\Item;
use App\Globals\CommissionCalculator;
use App\Globals\SalesAgent;

use Carbon\Carbon;
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
}