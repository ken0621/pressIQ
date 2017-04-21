<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_employee;
use App\Models\Tbl_position;
use App\Models\Tbl_sir;
use App\Models\Tbl_manual_receive_payment;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_manual_invoice;
use App\Globals\Employee;
use Validator;
use Carbon\Carbon;
use App\Globals\Utilities;
use Crypt;

class AgentTransactionController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function agents_transaction($agent_id)
    {
        $data["agent_id"] = $agent_id;
        $data["day"] = Carbon::now()->subDays(1);
        // dd(Request::input("start_date"));
        $start_date = date("Y-m-d H:i:s",strtotime(Carbon::now()->subDays(1)->format("Y-m-d") . " 00:00:00"));
        $end_date = date("Y-m-d H:i:s",strtotime(Carbon::now()));    
        if(Request::input("start_date") != null && Request::input("end_date") != null)
        {
           $start_date = date("Y-m-d H:i:s",strtotime(Request::input("start_date")));
           $end_date   = date("Y-m-d H:i:s", strtotime(Request::input("end_date")));   
        }
        $data["agent"] = Tbl_employee::position()->where("employee_id",$agent_id)->first();
    
        $data["_sir"] = Tbl_sir::where("sales_agent_id",$agent_id)->whereIn("ilr_status",[1,2])->get();

        $data["__transaction"] = array();
        foreach ($data["_sir"] as $key => $value) 
        {
            //for invoice
            $data["invoices"] = Tbl_manual_invoice::customer_invoice()->whereBetween("manual_invoice_date",array($start_date,$end_date))->where("sir_id",$value->sir_id)->get(); 

            //union of invoice and receive payment
            foreach ($data["invoices"] as $inv_key => $inv_value) 
            {
                $cm = Tbl_credit_memo::where("cm_id",$inv_value->credit_memo_id)->first();
                $cm_amt = 0;
                if($cm != null)
                {
                  $cm_amt = $cm->cm_amount;  
                }
                $_transaction[$inv_key]['date'] = $inv_value->inv_date;
                $_transaction[$inv_key]['type'] = 'Invoice';
                $_transaction[$inv_key]['reference_name'] = 'invoice';
                $_transaction[$inv_key]['customer_name'] = $inv_value->title_name." ".$inv_value->first_name." ".$inv_value->last_name." ".$inv_value->suffix_name;
                $_transaction[$inv_key]['no'] = $inv_value->inv_id;
                $_transaction[$inv_key]['balance'] = ($inv_value->inv_overall_price - $inv_value->inv_payment_applied) - $cm_amt;
                $_transaction[$inv_key]['due_date'] = $inv_value->inv_due_date;
                $_transaction[$inv_key]['total'] = $inv_value->inv_overall_price;
                $_transaction[$inv_key]['status'] = $inv_value->inv_is_paid;

                array_push($data['__transaction'], $_transaction);
            }
        }
        foreach ($data["_sir"] as $keys => $values) 
        {
            //for receive payment
            $data["rcv_payment"] = Tbl_manual_receive_payment::customer_receive_payment()->whereBetween("tbl_manual_receive_payment.rp_date",array($start_date,$end_date))->where("sir_id",$values->sir_id)->get();
            foreach ($data["rcv_payment"] as $rp_key => $rp_value) 
            {
                $_transaction[$rp_key]['date'] = $rp_value->rp_date;
                $_transaction[$rp_key]['type'] = 'Payment';
                $_transaction[$rp_key]['reference_name'] = 'receive_payment';
                $_transaction[$rp_key]['customer_name'] = $rp_value->title_name." ".$rp_value->first_name." ".$rp_value->last_name." ".$rp_value->suffix_name;
                $_transaction[$rp_key]['no'] = $rp_value->rp_id;
                $_transaction[$rp_key]['balance'] = 0;
                $_transaction[$rp_key]['due_date'] = $rp_value->rp_date;
                $_transaction[$rp_key]['total'] = $rp_value->rp_total_amount;
                $_transaction[$rp_key]['status'] = 'status';

                array_push($data['__transaction'], $_transaction);
            }

        }


        // dd($data['__transaction']);
        return view("member.purchasing_inventory_system.agent_transactions.agent_transactions",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
