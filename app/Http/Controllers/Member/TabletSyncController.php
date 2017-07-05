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
use App\Globals\CreditMemo;
use App\Globals\ReceivePayment;
use App\Globals\Tablet_global;

use App\Models\Tbl_terms;
use App\Models\Tbl_category;
use App\Models\Tbl_payment_method;
use App\Models\Tbl_manual_credit_memo;
use App\Models\Tbl_employee;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_sir;
use App\Models\Tbl_customer;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_user;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_manual_receive_payment;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_sir_inventory;
use App\Models\Tbl_position;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_item;
use App\Models\Tbl_shop;

use Session;
use Crypt;
use Validator;
use Redirect;
use Carbon\Carbon;


class TabletSyncController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync($table)
    {
        $return = [];
        if($table == "tbl_shop")
        {
            $data = Tbl_shop::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_shop (shop_id, shop_key, shop_date_created, shop_date_expiration, shop_last_active_date, shop_status, shop_country, shop_city, shop_zip, shop_street_address, shop_contact, url, shop_domain, shop_theme, shop_theme_color, member_layout, shop_wallet_tours, shop_wallet_tours_uri, shop_merchant_school, created_at, updated_at) VALUES " . "(".$value->shop_id.",'".$value->shop_key."','".$value->shop_date_created."','".$value->shop_date_expiration."','".$value->shop_last_active_date."','".$value->shop_status."','".$value->shop_country."','".$value->shop_city."','".$value->shop_zip."','".$value->shop_street_address."','".$value->shop_contact."','".$value->url."','".$value->shop_domain."','".$value->shop_theme."','".$value->shop_theme_color."','".$value->member_layout."','".$value->shop_wallet_tours."','".$value->shop_wallet_tours_uri."','".$value->shop_merchant_school."','".$value->created_at."','".$value->updated_at."')";
            }
        }
        if($table == "tbl_category")
        {
            $data = Tbl_category::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_category (type_id, type_name, type_parent_id, type_sub_level, type_shop, type_category, type_date_created, is_mts, created_at, updated_at) VALUES " . "(".$value->type_id.",'".$value->type_name."','".$value->type_parent_id."','".$value->type_sub_level."','".$value->type_shop."','".$value->type_category."','".$value->type_date_created."','".$value->is_mts."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_audit_trail")
        {
            $data = Tbl_audit_trail::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_audit_trail (audit_trail_id, user_id, remarks, old_data, new_data, created_at, updated_at, source, source_id, audit_shop_id) VALUES " . "(".$value->audit_trail_id.",'".$value->user_id."','".$value->remarks."','".$value->old_data."','".$value->new_data."','".$value->created_at."','".$value->updated_at."','".$value->source."','".$value->source_id."','".$value->audit_shop_id."')";
            }
        }

        if($table == "tbl_chart_account_type")
        {
            $data = Tbl_chart_account_type::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_chart_account_type (chart_type_id, chart_type_name, chart_type_description, has_open_balance, chart_type_category, normal_balance, created_at, updated_at) VALUES " . "(".$value->chart_type_id.",'".$value->chart_type_name."','".$value->chart_type_description."','".$value->has_open_balance."','".$value->chart_type_category."','".$value->normal_balance."','".$value->created_at."','".$value->updated_at."')";
            }
        }
        if($table == "tbl_chart_of_account")
        {
            $data = Tbl_chart_of_account::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_chart_of_account (account_id, account_shop_id, account_type_id, account_number, account_name, account_full_name, account_description, account_parent_id, account_sublevel, account_balance, account_open_balance, account_open_balance_date, is_tax_account, account_tax_code_id, archived, account_timecreated, account_protected, account_code, created_at, updated_at) VALUES " . "(".$value->account_id.",'".$value->account_shop_id."','".$value->account_type_id."','".$value->account_number."','".$value->account_name."','".$value->account_full_name."','".$value->account_description."','".$value->account_parent_id."','".$value->account_sublevel."','".$value->account_balance."','".$value->account_open_balance."','".$value->account_open_balance_date."','".$value->is_tax_account."','".$value->account_tax_code_id."','".$value->archived."','".$value->account_timecreated."','".$value->account_protected."','".$value->account_code."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_country")
        {
            $data = Tbl_country::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_country (country_id, country_code, country_name, created_at, updated_at) VALUES " . "(".$value->country_id.",'".$value->country_code."','".$value->country_name."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_credit_memo")
        {
            $data = Tbl_credit_memo::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_credit_memo (cm_id, cm_customer_id, cm_shop_id, cm_ar_acccount, cm_customer_email, cm_date, cm_message, cm_memo, cm_amount, date_created, cm_type, cm_used_ref_name,cm_used_ref_id,create_at,updated_at) VALUES " . "(".$value->cm_id.",'".$value->cm_customer_id."','".$value->cm_shop_id."','".$value->cm_ar_acccount."','".$value->cm_customer_email."','".$value->cm_date."','".$value->cm_message."','".$value->cm_memo."','".$value->cm_amount."','".$value->date_created."','".$value->cm_type."','".$value->cm_used_ref_name."','".$value->cm_used_ref_id."','".$value->create_at."','".$value->updated_at."')";
            }
        }
        if($table == "tbl_credit_memo_line")
        {
            $data = Tbl_credit_memo_line::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_credit_memo_line (cmline_id, cmline_cm_id, cmline_service_date, cmline_um, cmline_item_id, cmline_description, cmline_qty, cmline_rate, cm_amount, cmline_amount, create_at,updated_at) VALUES " . "(".$value->cmline_id.",'".$value->cmline_cm_id."','".$value->cmline_service_date."','".$value->cmline_um."','".$value->cmline_item_id."','".$value->cmline_description."','".$value->cmline_qty."','".$value->cmline_rate."','".$value->cm_amount."','".$value->cmline_amount."','".$value->create_at."','".$value->updated_at."')";
            }
        }

        return json_encode($return);
    }
    public function sync_update()
    {
        $table_name = Request::input("table");
        $dataset = Request::input("dataset");
        
        $new_data = json_decode($dataset);
        // dd($new_data);
        foreach($new_data as $key => $value)
        {
            if($table_name == "tbl_shop")
            {
                $up["shop_key"] = $value->shop_key;
                $up["shop_date_created"] = $value->shop_date_created;
                $up["shop_date_expiration"] = $value->shop_date_expiration;
                $up["shop_last_active_date"] = $value->shop_last_active_date;
                $up["shop_status"] = $value->shop_status;
                $up["shop_country"] = $value->shop_country;
                $up["shop_city"] = $value->shop_city;
                $up["shop_zip"] = $value->shop_zip;
                $up["shop_street_address"] = $value->shop_street_address;
                $up["shop_contact"] = $value->shop_contact;
                $up["url"] = $value->url;
                $up["shop_domain"] = $value->shop_domain;
                $up["shop_theme"] = $value->shop_theme;
                $up["shop_theme_color"] = $value->shop_theme_color;
                $up["member_layout"] = $value->member_layout;
                $up["shop_wallet_tours"] = $value->shop_wallet_tours;
                $up["shop_wallet_tours_uri"] = $value->shop_wallet_tours_uri;
                $up["shop_merchant_school"] = $value->shop_merchant_school;
                $up["shop_wallet_tours"] = $value->shop_wallet_tours;
                $up["created_at"] = $value->created_at;
                $up["updated_at"] = $value->updated_at;
                
                Tbl_shop::where("shop_id",$value->shop_id)->update($up);
            }
        }
        
        return "success";
        
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
