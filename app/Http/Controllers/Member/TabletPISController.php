<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Globals\UnitMeasurement;
use App\Globals\Item;
use App\Globals\Tablet_invoice;
use App\Globals\Invoice;
use App\Globals\Purchasing_inventory_system;
use App\Models\Tbl_employee;
use App\Models\Tbl_sir;
use App\Models\Tbl_customer;
use App\Models\Tbl_temp_customer_invoice;
use App\Models\Tbl_temp_customer_invoice_line;
use Session;
use Crypt;
use Redirect;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_item;

class TabletPISController extends Member
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data["_sir"] = Purchasing_inventory_system::tablet_sir_per_sales_agent($this->user_info->shop_id,'array',1,0,null,1,$this->get_user()->employee_id);

		$data["employee_name"] = $this->get_user()->first_name." ".$this->get_user()->middle_name." ".$this->get_user()->last_name;
		$data["employee_position"] = $this->get_user()->position_name;
		return view("tablet.dashboard",$data);
	}
	public function logout()
	{
		Session::forget('sales_agent');
		return Redirect::to("/tablet");
	}
	public function get_user()
	{
		$user = Session::get("sales_agent");
		if($user != null)
		{
			return $user;
		}
		else
		{
			return Redirect::to('/tablet');
		}
	}
	public function inventory_sir($sir_id)
	{
		$data = Purchasing_inventory_system::get_inventory_in_sir($sir_id);

		return view('tablet.sir_inventory',$data);
	}
	public function view_invoices($sir_id)
	{        
		$data["_invoices"] = Tbl_manual_invoice::sir()->customer_invoice()->where("tbl_sir.sir_id",$sir_id)->orderBy("tbl_temp_customer_invoice.inv_id","DESC")->get();
		$data["sir_id"] = $sir_id;
		return view("member.customer_invoice.customer_invoice_list",$data);
	}
	public function sync_import()
	{
		$update["is_sync"] = 1;
		Tbl_sir::where("sales_agent_id",$this->get_user()->employee_id)->where("sir_status",1)->update($update);

		$data["status"] = "success";

		return json_encode($data);
	}
	public function tablet_create_invoice($sir_id)
	{         
		$data["_customer"]  = Tbl_customer::where("archived", 0)->get();
		// $data["_item"]      = Tbl_item::where("archived", 0)->get();
		$data['_item']      = Item::get_all_item_sir($sir_id);
		$data["sir_id"] = $sir_id;
		// dd($data["sir_id"]);
		$data["action"] = "/tablet/create_invoice/add_submit";
		// dd($data["_item"]);
		return view('member.customer_invoice.customer_invoice', $data);
	}
	public function create_invoice_submit()
	{
		$sir_id = Request::input("sir_id");
		$data["status"] = "";
		$data["status_message"] = "";

		$customer_info                      = [];
		$customer_info['customer_id']       = Request::input('inv_customer_id');;
		$customer_info['customer_email']    = Request::input('inv_customer_email');

		$invoice_info                       = [];
		$invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
		$invoice_info['invoice_date']       = Request::input('inv_date');
		$invoice_info['invoice_due']        = Request::input('inv_due_date');
		$invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

		$invoice_other_info                 = [];
		$invoice_other_info['invoice_msg']  = Request::input('inv_message');
		$invoice_other_info['invoice_memo'] = Request::input('inv_memo');

		$total_info                         = [];
		$total_info['total_subtotal_price'] = str_replace(',', "", Request::input('subtotal_price'));
		$total_info['ewt']                  = Request::input('ewt');
		$total_info['total_discount_type']  = Request::input('inv_discount_type');
		$total_info['total_discount_value'] = Request::input('inv_discount_value');
		$total_info['taxable']              = Request::input('taxable');
		$total_info['total_overall_price']  = Request::input('overall_price');

		$item_info                          = [];
		$_itemline                          = Request::input('invline_item_id');

		$return = 0;
		foreach($_itemline as $key => $item_line)
		{
			if($item_line)
			{
				$item_info[$key]['item_service_date']  = Request::input('invline_service_date')[$key];
				$item_info[$key]['item_id']            = Request::input('invline_item_id')[$key];
				$item_info[$key]['item_description']   = Request::input('invline_description')[$key];
				$item_info[$key]['um']                 = Request::input('invline_um')[$key];
				$item_info[$key]['quantity']           = str_replace(',', "",Request::input('invline_qty')[$key]);
				$item_info[$key]['rate']               = str_replace(',', "", Request::input('invline_rate')[$key]);
				$item_info[$key]['discount']           = Request::input('invline_discount')[$key];
				$item_info[$key]['discount_remark']    = Request::input('invline_discount_remark')[$key];
				$item_info[$key]['taxable']            = Request::input('invline_taxable')[$key];
				$item_info[$key]['amount']             = str_replace(',', "", Request::input('invline_amount')[$key]);

				$return += Purchasing_inventory_system::check_qty_sir($sir_id, Request::input('invline_item_id')[$key],Request::input('invline_um')[$key],Request::input('invline_qty')[$key]);
				if($return != 0)
				{
					$item_name[$key] = Tbl_item::where("item_id",Request::input("invline_item_id")[$key])->pluck("item_name");
				}

				$um_info = UnitMeasurement::um_info(Request::input("invline_um")[$key]);
				$product_consume[$key]["quantity"] = $um_info->unit_qty * $item_info[$key]['quantity'];
				$product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
			}
		}

		if($return == 0)
		{
		   $invoice_id = Tablet_invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);
		   // $remarks = "Manual Invoice consume";
		   // $warehouse_id = Tbl_warehouse::where("warehouse_shop_id",$this->user_info->shop_id)->where("main_warehouse",1)->pluck("warehouse_id");
		   // $transaction_type = "invoice";
		   // $transaction_id = $invoice_id;
		   // $data = Warehouse::inventory_consume($warehouse_id, $remarks, $product_consume,$consumer_id = 0, $consume_cause = '', $return = 'array', $transaction_type, $transaction_id);
			  
		   if($sir_id != null && $invoice_id != null)
		   {
				$insert_manual_invoice["sir_id"] = $sir_id;
				$insert_manual_invoice["inv_id"] = $invoice_id;

				Tbl_manual_invoice::insert($insert_manual_invoice);

				foreach($_itemline as $keys => $item_line)
				{
					if($item_line)
					{
						Purchasing_inventory_system::mark_as_sold($sir_id, Request::input('invline_item_id')[$keys],Request::input('invline_um')[$keys],Request::input('invline_qty')[$keys]);
					}
				}
				$data["status"] = "success-tablet";
		   }
		   else
		   {
				$data["status"] = "error";
				$data["status_message"] = "error";
		   }
		}
		else
		{
			$data["status"] = "error";
			foreach ($item_name as $key_item => $value_item) 
			{
				$data["status_message"] .= "<li style='list-style:none'>The quantity of ".$value_item." is not enough.</li>";
			}
		}
	   return json_encode($data);
	}

	public function login()
	{
		if(Session::get("sales_agent"))
		{
			return Redirect::to("/tablet/dashboard");
		}
		else
		{
			return view("tablet.login");
		}
	}
	public function login_submit()
	{
		$username = Request::input("username");
		$password = Request::input("password");

		$data["status"] = null;
		$data["status_message"] = null;

		$data["account"] = Tbl_employee::position()->where("username",$username)->where("position_code","sales_agent")->first();

		if($data["account"] != null)
		{
			if(Crypt::decrypt($data["account"]->password) == $password)
			{
				$data["status"] = "success-login";
				Session::put("sales_agent",$data["account"]);
			}
			else
			{
				$data["status"] = "error";
				$data["status_message"] = "The Username / Password is Incorrect";
			}
		}
		else
		{
			$data["status"] = "error";
			$data["status_message"] = "The Username / Password is Incorrect";
		}

		return json_encode($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sync_export()
	{
		$data["status"] = "success";

		$all = Tbl_manual_invoice::sir()->where("sales_agent_id",$this->get_user()->employee_id)->customer_invoice() 
										->where("tbl_manual_invoice.is_sync",0)
										->get();

		foreach ($all as $key => $value) 
		{
				$customer_info                      = [];
				$customer_info['customer_id']       = $value->inv_customer_id;
				$customer_info['customer_email']    = $value->inv_customer_email;

				$invoice_info                       = [];
				$invoice_info['invoice_terms_id']   = $value->inv_terms_id;
				$invoice_info['invoice_date']       = $value->inv_date;
				$invoice_info['invoice_due']        = $value->inv_due_date;
				$invoice_info['billing_address']    = $value->inv_customer_billing_address;

				$invoice_other_info                 = [];
				$invoice_other_info['invoice_msg']  = $value->inv_message;
				$invoice_other_info['invoice_memo'] = $value->inv_memo;

				$total_info                         = [];
				$total_info['total_subtotal_price'] = $value->inv_subtotal_price;
				$total_info['ewt']                  = $value->ewt;
				$total_info['total_discount_type']  = $value->inv_discount_type;
				$total_info['total_discount_value'] = $value->inv_discount_value;
				$total_info['taxable']              = $value->taxable;
				$total_info['total_overall_price']  = $value->inv_overall_price;

				$item_info                          = [];
				$_itemline                          = Tbl_temp_customer_invoice_line::where("invline_inv_id",$value->inv_id)->get();

			$return = 0;
	        foreach($_itemline as $keys => $item_line)
	        {
	            if($item_line)
	            {
	                $item_info[$keys]['item_service_date']  = $item_line->invline_service_date;
	                $item_info[$keys]['item_id']            = $item_line->invline_item_id;
	                $item_info[$keys]['item_description']   = $item_line->invline_description;
	                $item_info[$keys]['um']                 = $item_line->invline_um;
	                $item_info[$keys]['quantity']           = $item_line->invline_qty;
	                $item_info[$keys]['rate']               = $item_line->invline_rate;
	                $item_info[$keys]['discount']           = $item_line->invline_discount;
	                $item_info[$keys]['discount_remark']    = $item_line->invline_discount_remark;
	                $item_info[$keys]['taxable']            = $item_line->taxable;
	                $item_info[$keys]['amount']             = $item_line->invline_amount;
	            }
	        }
           $invoice_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);

           $update["inv_id"] = $invoice_id;
           $update["is_sync"] = 1;
           Tbl_manual_invoice::where("manual_invoice_id",$value->manual_invoice_id)->update($update);
           Tbl_temp_customer_invoice::where("inv_id",$value->inv_id)->update($update);
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
	public function destroy($id)
	{
		//
	}
}
