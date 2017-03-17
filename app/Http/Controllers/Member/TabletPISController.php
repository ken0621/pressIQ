<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Globals\UnitMeasurement;
use App\Globals\Item;
use App\Globals\Tablet_invoice;
use App\Globals\Invoice;
use App\Globals\Transaction;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Customer;
use App\Globals\Accounting;
use App\Globals\Pdf_global;
use App\Globals\Category;

use App\Models\Tbl_payment_method;
use App\Models\Tbl_employee;
use App\Models\Tbl_sir;
use App\Models\Tbl_customer;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_user;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_manual_receive_payment;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use App\Models\Tbl_unit_measurement_multi;
use Session;
use Crypt;
use Redirect;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_item;
use Carbon\Carbon;

class TabletPISController extends Member
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function confirm_submission()
	{
		$data["action"] = "sync";

		return view("tablet.agent.confirm_sync",$data);
	}
	public function submit_transactions()
	{		
        $data = Purchasing_inventory_system::close_sir_general();

        return json_encode($data);
	}
	public function index()
	{
		$data["sir"] = Purchasing_inventory_system::tablet_lof_per_sales_agent($this->user_info->shop_id,'array',1,null,$this->get_user()->employee_id);

        $data['_category']  = Category::getAllCategory(["inventory","all"]);

        if($data["sir"])
        {
            $data["_sir_item"] = Purchasing_inventory_system::get_sir_item($data["sir"]->sir_id);
        }
		$data["employee_name"] = $this->get_user()->first_name." ".$this->get_user()->middle_name." ".$this->get_user()->last_name;
		$data["employee_position"] = $this->get_user()->position_name;
		$data["employee_id"] = $this->get_user()->employee_id;

		$data["ctr_open_sir"] = Tbl_sir::where("sales_agent_id",$this->get_user()->employee_id)->where("sir_status",1)->count();

		$data["open_sir"] = Tbl_sir::truck()->saleagent()->where("sales_agent_id",$this->get_user()->employee_id)->where("sir_status",1)->first();
        if($data["open_sir"])
        {   
            Session::forget("selected_sir");
            Session::put("selected_sir",$data["open_sir"]->sir_id);
      
			$data["_invoices"] = Tbl_manual_invoice::sir()->customer_invoice()->where("tbl_sir.sir_id",Session::get("selected_sir"))->orderBy("tbl_customer_invoice.inv_id","DESC")->where("inv_is_paid",0)->get();

            $data["total_invoice_amount"] = 0;
            foreach ($data["_invoices"] as $key => $value) 
            {
                $data["total_invoice_amount"] += $value->inv_overall_price;
            }

            $data["_receive_payment"] = Tbl_manual_receive_payment::sir()->customer_receive_payment()->where("tbl_sir.sir_id",Session::get("selected_sir"))->orderBy("tbl_receive_payment.rp_id","DESC")->get();
            $data["total_receive_payment"] = 0;
            foreach ($data["_receive_payment"] as $key => $value) 
            {
                $data["total_receive_payment"] += $value->rp_total_amount;
            }

            $data["total_receive_payment"] = currency("Php", $data["total_receive_payment"]);
            $data["total_invoice_amount"] = currency("Php", $data["total_invoice_amount"]);
            $data["total_customer"] = Customer::countAllCustomer();

			$data["_customer"] = Customer::getAllCustomer();


			return view("tablet.agent.agent_dashboard",$data);
		}
		else
		{
			return view("tablet.index",$data);
		}
	}
	public function selected_sir()
	{
		Session::forget("selected_sir");
		$sir_id = Request::input("sir_id");

		Session::put("selected_sir",$sir_id);

		$data["status"] = "success";
		return json_encode($data);
	}
    public function invoice()
    {
        $data["employee_name"] = $this->get_user()->first_name." ".$this->get_user()->middle_name." ".$this->get_user()->last_name;
        $data["employee_position"] = $this->get_user()->position_name;
        $data["employee_id"] = $this->get_user()->employee_id;

        if(Session::get("selected_sir") != null)
        {
            $data["_invoices"] = Tbl_manual_invoice::sir()->customer_invoice()->where("tbl_sir.sir_id",Session::get("selected_sir"))->orderBy("tbl_customer_invoice.inv_id","DESC")->get();
        }
        return view("tablet.agent.invoice",$data);

    }
    public function customer()
    {   
        $data["employee_name"] = $this->get_user()->first_name." ".$this->get_user()->middle_name." ".$this->get_user()->last_name;
        $data["employee_position"] = $this->get_user()->position_name;
        $data["employee_id"] = $this->get_user()->employee_id;

        if(Session::get("selected_sir") != null)
        {    
            $data["_customer"] = Customer::getAllCustomer();
        }
        return view("tablet.agent.customer",$data);
    }
    public function checkuser($str = '')
    {
        $user_info = $this->user_info;
        switch ($str) {
            case 'user_id':
                return $user_info->user_id;
                break;
            case 'user_shop':
                return $user_info->user_shop;
                break;
            default:
                return '';
                break;
        }
    }
    public function customer_details($id)
    {
        $data["customer"]       = Tbl_customer::info()->balance($this->checkuser('user_shop'), $id)->where("tbl_customer.customer_id", $id)->first();
        $data["_transaction"]   = Tbl_customer::transaction($this->checkuser('user_shop'), $id)->get();

        return view("tablet.agent.customer_details",$data);
    }
    public function receive_payment()
    {
        $data["employee_name"] = $this->get_user()->first_name." ".$this->get_user()->middle_name." ".$this->get_user()->last_name;
        $data["employee_position"] = $this->get_user()->position_name;
        $data["employee_id"] = $this->get_user()->employee_id;

        if(Session::get("selected_sir") != null)
        {
            $data["_receive_payment"] = Tbl_manual_receive_payment::sir()->customer_receive_payment()->where("tbl_sir.sir_id",Session::get("selected_sir"))->orderBy("tbl_receive_payment.rp_id","DESC")->get();
        }
        return view("tablet.agent.receive_payment",$data);
    }
	public function review_sir($sir_id)
	{
        $data["sir_id"] = $sir_id;
        $data["type_code"] = "lof";
	    $data["type"] = "Load Out Form";
	    $data["tablet"] = "confirm_reject";

        return view("member.purchasing_inventory_system.sir_view",$data);
	}
	public function lof_action($id, $action)
	{
     	$data["sir_id"] = $id;
        $data["action"] = $action;

        return view("tablet.confirm_tablet",$data);
	}
	public function lof_action_submit()
	{
        $id = Request::input("sir_id");
        $action = Request::input("action");

        if($action == "confirm")
        {
        	$update["lof_status"] = 2;
        	
        }
        else if($action == "reject")
        {
        	$update["lof_status"] = 3;
            $update["rejection_reason"] = Request::input("reason_txt");
        }

        Tbl_sir::where("sir_id",$id)->update($update);

        $data["status"] = "success";

        return json_encode($data);

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
		$data["_invoices"] = Tbl_manual_invoice::sir()->customer_invoice()->where("tbl_sir.sir_id",$sir_id)->orderBy("Tbl_customer_invoice.inv_id","DESC")->get();
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
	 public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
	public function tablet_create_invoice()
	{         
		$sir_id = Request::input("sir_id");
        $data["c_id"] = Request::input("customer_id");
        
		$data["_customer"]  = Customer::getAllCustomer();
        $data['_um']        = UnitMeasurement::load_um_multi();
		$data['_item']      = Item::get_all_item_sir($sir_id);
        $data["new_inv_id"] = Transaction::get_last_number("tbl_customer_invoice","new_inv_id","inv_shop_id"); 
		$data["sir_id"] = $sir_id;
		// dd($data["sir_id"]);
		$data["action"] = "/tablet/create_invoice/add_submit";
		// dd($data["_item"]);
		$id = Request::input("id");
		$sir = Tbl_manual_invoice::where("inv_id",$id)->first();

        if($sir)
        {
            $data["inv"]            = Tbl_customer_invoice::appliedPayment($this->getShopId())->where("inv_id", $id)->first();
            
            $data["_invline"]       = Tbl_customer_invoice_line::um()->where("invline_inv_id", $id)->get();

            $data["sir_id"] = $sir->sir_id;
            $data["action"] = "/tablet/update_invoice/edit_submit";
            $data['_item'] = Item::get_all_item_sir($sir->sir_id);
        }

		return view('member.customer_invoice.customer_invoice', $data);
	}
	public function tablet_receive_payment()
	{
		$data["c_id"] = Request::input("customer_id");
	    $data["_customer"]      = Customer::getAllCustomer();
        $data['_account']       = Accounting::getAllAccount();
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();
        $data['action']         = "/tablet/receive_payment/add_submit";
        $data["_invoice"] = Invoice::getAllInvoiceByCustomer($data["c_id"]);

        $id = Request::input('id');
        if($id)
        {
            $data["rcvpayment"]         = Tbl_receive_payment::where("rp_id", $id)->first();
            $data["_rcvpayment_line"]   = Tbl_receive_payment_line::where("rpline_rp_id", $id)->get();
            $data["_invoice"]           = Invoice::getAllInvoiceByCustomerWithRcvPymnt($data["rcvpayment"]->rp_customer_id, $data["rcvpayment"]->rp_id);
            // dd($data["_invoice"]);
            $data['action']             = "/tablet/receive_payment/update/".$data["rcvpayment"]->rp_id;
        }

        return view("member.receive_payment.receive_payment", $data);
	}
	public function add_receive_payment()
	{

		$insert["rp_shop_id"]           = $this->getShopId();
        $insert["rp_customer_id"]       = Request::input('rp_customer_id');
        $insert["rp_ar_account"]        = Request::input('rp_ar_account') or 0;
        $insert["rp_date"]              = datepicker_input(Request::input('rp_date'));
        $insert["rp_total_amount"]      = convertToNumber(Request::input('rp_total_amount'));
        $insert["rp_payment_method"]    = Request::input('rp_payment_method');
        $insert["rp_memo"]              = Request::input('rp_memo');
        $insert["date_created"]         = Carbon::now();

        $rcvpayment_id  = Tbl_receive_payment::insertGetId($insert);

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["rpline_rp_id"]            = $rcvpayment_id;
                $insert_line["rpline_reference_name"]   = Request::input('rpline_txn_type')[$key];
                $insert_line["rpline_reference_id"]     = Request::input('rpline_txn_id')[$key];
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]);

                Tbl_receive_payment_line::insert($insert_line);
                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
                }
            }
        }

        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;
        $json["message"]        = "Successfully received payment";
        $json["url"]            = "/tablet/receive_payment";

        $ins_manual_rcv_pymnt["rp_id"] = $rcvpayment_id;
        $ins_manual_rcv_pymnt["sir_id"] = Session::get("selected_sir");
        $ins_manual_rcv_pymnt["rp_date"] = Carbon::now();
        $ins_manual_rcv_pymnt["agent_id"] = $this->get_user()->employee_id;

        Tbl_manual_receive_payment::insert($ins_manual_rcv_pymnt);

        if($button_action == "save-and-edit")
        {
            $json["redirect"]    = "/tablet/receive_payment/add?id=".$rcvpayment_id;
        }

        return json_encode($json);
	}
	public function update_receive_payment($rcvpayment_id)
    {
        // dd(Request::input());

        $update["rp_customer_id"]       = Request::input('rp_customer_id');
        $update["rp_ar_account"]        = Request::input('rp_ar_account') or 0;
        $update["rp_date"]              = datepicker_input(Request::input('rp_date'));
        $update["rp_total_amount"]      = convertToNumber(Request::input('rp_total_amount'));
        $update["rp_payment_method"]    = Request::input('rp_payment_method');
        $update["rp_memo"]              = Request::input('rp_memo');

        Tbl_receive_payment::where("rp_id", $rcvpayment_id)->update($update);
        Tbl_receive_payment_line::where("rpline_rp_id", $rcvpayment_id)->delete();

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["rpline_rp_id"]            = $rcvpayment_id;
                $insert_line["rpline_reference_name"]   = Request::input('rpline_txn_type')[$key];
                $insert_line["rpline_reference_id"]     = Request::input('rpline_txn_id')[$key];
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]);

                Tbl_receive_payment_line::insert($insert_line);
                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
                }
            }
        }

        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;
        $json["message"]        = "Successfully updated payment";
        $json["redirect"]            = "/tablet/receive_payment/add?id=".$rcvpayment_id;
        
        if($button_action == "save-and-new")
        {
            $json["redirect"]   = '/tablet/receive_payment/add';
        }

        return json_encode($json);
    }
	public function update_invoice_submit()
	{
		$invoice_id = Request::input("invoice_id");
        $sir_id = Request::input("sir_id");
        $data["status_message"] = "";

        $customer_info                      = [];
        $customer_info['customer_id']       = Request::input('inv_customer_id');;
        $customer_info['customer_email']    = Request::input('inv_customer_email');

        $invoice_info                       = [];
        $invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
        $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $invoice_info['invoice_date']       = datepicker_input(Request::input('inv_date'));
        $invoice_info['invoice_due']        = datepicker_input(Request::input('inv_due_date'));
        $invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

        $invoice_other_info                 = [];
        $invoice_other_info['invoice_msg']  = Request::input('inv_message');
        $invoice_other_info['invoice_memo'] = Request::input('inv_memo');

        $total_info                         = [];
        $total_info['total_subtotal_price'] = Request::input('subtotal_price');
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['total_discount_type']  = Request::input('inv_discount_type');
        $total_info['total_discount_value'] = Request::input('inv_discount_value');
        $total_info['taxable']              = Request::input('taxable');
        $total_info['total_overall_price']  = Request::input('overall_price');

        $item_info                          = [];
        $_itemline                          = Request::input('invline_item_id');

        $item_name = '';
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


                $return += Purchasing_inventory_system::check_qty_sir($sir_id, Request::input('invline_item_id')[$key],Request::input('invline_um')[$key],Request::input('invline_qty')[$key],$invoice_id,"tbl_customer_invoice_line");
                if($return != 0)
                {
                    $item_name[$key] = Tbl_item::where("item_id",Request::input("invline_item_id")[$key])->pluck("item_name");
                }

                $um_info = UnitMeasurement::um_info(Request::input("invline_um")[$key]);
                $product_consume[$key]["quantity"] = (isset($um_info->unit_qty) ? $um_info->unit_qty : 1) * $item_info[$key]['quantity'];
                $product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
            }
        }

        if($return == 0)
        {

            $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

            if($inv <= 1 || Request::input("keep_val") == "keep")
            {
                $inv_item = Tbl_customer_invoice_line::where("invline_inv_id",$invoice_id)->get();
                // dd($inv_item);
                foreach ($inv_item as $keys => $value) 
                {                 
                    Purchasing_inventory_system::return_qty($sir_id, $value->invline_item_id, $value->invline_um, $value->invline_qty); 
                }

                $inv_id = Invoice::updateInvoice($invoice_id, $customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);


                foreach($_itemline as $key => $item_line)
                {
                    if($item_line)
                    {
                        Purchasing_inventory_system::mark_as_sold($sir_id, Request::input('invline_item_id')[$key],Request::input('invline_um')[$key],Request::input('invline_qty')[$key]); 
                    }
                }

                $data["status"] = "success-tablet";
            }
            else
            {
                $data["inv_id"] = Request::input("new_invoice_id");            
                $data["status"] = "error-inv-no";
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
        $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
		$invoice_info['invoice_date']       = datepicker_input(Request::input('inv_date'));
		$invoice_info['invoice_due']        = datepicker_input(Request::input('inv_due_date'));
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

				$return += Purchasing_inventory_system::check_qty_sir($sir_id, Request::input('invline_item_id')[$key],Request::input('invline_um')[$key],Request::input('invline_qty')[$key],0,"tbl_customer_invoice_line");
				if($return != 0)
				{
					$item_name[$key] = Tbl_item::where("item_id",Request::input("invline_item_id")[$key])->pluck("item_name");
				}

				$um_info = UnitMeasurement::um_info(Request::input("invline_um")[$key]);
				$qty = 1;
				if($um_info != null)
				{
					$qty = $um_info->unit_qty;
				}

				$product_consume[$key]["quantity"] = $qty * $item_info[$key]['quantity'];
				$product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
			}
		}

		if($return == 0)
		{
		    $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

	        if($inv == 0 || Request::input("keep_val") == "keep")
	        {
		   		$invoice_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);

			   if($sir_id != null && $invoice_id != null)
			   {
					$insert_manual_invoice["sir_id"] = $sir_id;
                    $insert_manual_invoice["inv_id"] = $invoice_id;
                    $insert_manual_invoice["manual_invoice_date"] = Carbon::now();

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
				$data["inv_id"] = Request::input("new_invoice_id");            
            	$data["status"] = "error-inv-no";
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
	public function view_invoice_pdf($inv_id)
	{
		$data["invoice"] = Tbl_customer_invoice::customer()->where("inv_id",$inv_id)->first();

        $data["invoice_item"] = Tbl_customer_invoice_line::invoice_item()->where("invline_inv_id",$inv_id)->get();
        foreach($data["invoice_item"] as $key => $value) 
        {        	
            $um = Tbl_unit_measurement_multi::where("multi_id",$value->invline_um)->first();
          	$qty = 1;
            if($um != null)
            {
                $qty = $um->unit_qty;
            }

            $total_qty = $value->invline_qty * $qty;
            $data["invoice_item"][$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->invline_um);
        }
          $pdf = view('member.customer_invoice.invoice_pdf', $data);
          return Pdf_global::show_pdf($pdf);
	}
	public function view_invoices_view($id)
	{
		$data["invoice_id"] = $id;
		$data["action_load"] = "/tablet/view_invoice_pdf";
        return view("member.customer_invoice.invoice_view",$data);
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
				$_itemline                          = Tbl_customer_invoice_line::where("invline_inv_id",$value->inv_id)->get();

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
           Tbl_customer_invoice::where("inv_id",$value->inv_id)->update($update);
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
