<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Customer;
use App\Globals\Item;
use App\Globals\SalesAgent;
use App\Globals\CommissionCalculator;

use Carbon\Carbon;
class CommissionCalculatorController extends Member
{
    /**
     * Display a listing of the resource.
     * @author ARCYLEN
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['page'] = "Commission Calculator";
        $data['_list'] = CommissionCalculator::list($this->user_info->shop_id);
        return view('member.cashier.commission_calculator.commission_calculator_list',$data);
    }
    public function getCreate()
    {
        $data['page'] = "Commission Calculator";
        $data['_customer'] = Customer::getAllCustomer();
        $data['_agent'] = SalesAgent::get_list($this->user_info->shop_id);
        $data['_item'] = Item::get_all_category_item([2]);

        return view('member.cashier.commission_calculator.create',$data);        
    }
    public function postCreateSubmit(Request $request)
    {
        $shop_id = $this->user_info->shop_id;
        $comm['customer_id'] = $request->customer_id;
        $comm['customer_email'] = $request->customer_email;
        $comm['agent_id'] = $request->agent_id;
        $comm['date'] = datepicker_input($request->date);
        $comm['due_date'] = datepicker_input($request->due_date);
        $comm['total_selling_price'] = str_replace(',', '', $request->total_selling_price);
        $comm['total_contract_price'] = $request->total_contract_price;
        $comm['total_commission'] = $request->total_commission;
        $comm['loanable_amount'] = $request->loanable_amount;
        $comm['date_created'] = Carbon::now();

        $comm_item['item_id'] = $request->item_id;
        $comm_item['downpayment_percent'] = str_replace('%', '', $request->downpayment_percent);
        $comm_item['discount'] = str_replace(',', '',$request->discount);
        $comm_item['monthly_amort'] = $request->monthly_amort;
        $comm_item['misceleneous_fee_percent'] = str_replace('%', '', $request->misceleneous_fee_percent);
        $comm_item['ndp_commission'] = str_replace('%', '', $request->ndp_commission);
        $comm_item['tcp_commission'] = str_replace('%', '', $request->tcp_commission);

        $return = CommissionCalculator::create($shop_id, $comm, $comm_item);

        // die(var_dump('success'));
        if($return == 'success')
        {
            $data['status'] = $return;
            $data['call_function'] = 'success_commission';
            return json_encode($data);
        }
    }
    public function getLoadItem(Request $request)
    {
        $data['_item'] = Item::get_all_category_item([2]);
        return view('member.load_ajax_data.load_item_category',$data);
    }
}
