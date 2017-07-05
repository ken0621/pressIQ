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

        if($table == "tbl_customer")
        {
            $data = Tbl_customer::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_customer (customer_id, shop_id, country_id, title_name, first_name, middle_name, suffix_name, email, password, company, b_day,profile,IsWalkin, created_date, archived, ismlm,mlm_username,tin_number,is_corporate,approved,create_at,updated_at) VALUES " . "(".$value->customer_id.",'".$value->shop_id."','".$value->country_id."','".$value->title_name."','".$value->first_name."','".$value->middle_name."','".$value->suffix_name."','".$value->email."','".$value->password."','".$value->company."','".$value->b_day."','".$value->profile."','".$value->IsWalkin."','".$value->created_date."','".$value->archived."','".$value->ismlm."','".$value->mlm_username."','".$value->tin_number."','".$value->is_corporate."','".$value->approved."','".$value->create_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_customer_address")
        {
            $data = Tbl_customer_address::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_customer_address (customer_address_id, customer_id , country_id, customer_state, customer_city, customer_zipcode, customer_street, purpose, archived, created_at, updated_at) VALUES " . "(".$value->customer_address_id.",'".$value->customer_id."','".$value->country_id."','".$value->customer_state."','".$value->customer_city."','".$value->customer_zipcode."','".$value->customer_street."','".$value->purpose."','".$value->archived."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_customer_attachment")
        {
            $data = Tbl_customer_attachment::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_customer_attachment (customer_attachment_id, customer_id , customer_attachment_path, customer_attachment_name, customer_attachment_extension, mime_type, archived, created_at, updated_at) VALUES " . "(".$value->customer_attachment_id.",'".$value->customer_id."','".$value->customer_attachment_path."','".$value->customer_attachment_name."','".$value->customer_attachment_extension."','".$value->mime_type."','".$value->archived."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_customer_invoice")
        {
            $data = Tbl_customer_invoice::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_customer_invoice (inv_id, new_inv_id , inv_shop_id, inv_customer_id, inv_customer_email, inv_customer_billing_address, inv_terms_id, inv_date, inv_due_date,inv_message,inv_memo,inv_discount_type,inv_discount_value,ewt,taxable,inv_subtotal_price,inv_overall_price,inv_payment_applied,inv_is_paid,inv_custom_field_id,date_created,credit_memo_id,is_sales_receipt,sale_receipt_cash_account,created_at,updated_at) VALUES " . "(".$value->inv_id.",'".$value->new_inv_id."','".$value->inv_shop_id."','".$value->inv_customer_id."','".$value->inv_customer_email."','".$value->inv_customer_billing_address."','".$value->inv_terms_id."','".$value->inv_date."','".$value->inv_due_date."','".$value->inv_message."','".$value->inv_memo."','".$value->inv_discount_type."','".$value->inv_discount_value."','".$value->ewt."','".$value->taxable."','".$value->inv_subtotal_price."','".$value->inv_overall_price."','".$value->inv_payment_applied."','".$value->inv_is_paid."','".$value->inv_custom_field_id."','".$value->date_created."','".$value->credit_memo_id."','".$value->is_sales_receipt."','".$value->sale_receipt_cash_account."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_customer_invoice_line")
        {
            $data = Tbl_customer_invoice_line::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_customer_invoice_line (invline_id, invline_inv_id , invline_service_date, invline_item_id, invline_description, invline_um, invline_qty, invline_rate, taxable,invline_discount,invline_discount_type,invline_discount_remark,invline_amount,date_created,invline_ref_name,invline_ref_id,created_at,updated_at) VALUES " . "(".$value->invline_id.",'".$value->invline_inv_id."','".$value->invline_service_date."','".$value->invline_item_id."','".$value->invline_description."','".$value->invline_um."','".$value->invline_qty."','".$value->invline_rate."','".$value->taxable."','".$value->invline_discount."','".$value->invline_discount_type."','".$value->invline_discount_remark."','".$value->invline_amount."','".$value->date_created."','".$value->invline_ref_name."','".$value->invline_ref_id."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_default_chart_account")
        {
            $data = Tbl_default_chart_account::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_default_chart_account (default_id, default_type_id, default_number, default_name, default_description, default_parent_id, default_sublevel, default_balance, default_open_balance,default_open_balance_date,is_tax_account,account_tax_code_id,default_for_code,account_protected,created_at,updated_at) VALUES " . "(".$value->default_id.",'".$value->default_type_id."','".$value->default_number."','".$value->default_name."','".$value->default_description."','".$value->default_parent_id."','".$value->default_sublevel."','".$value->default_balance."','".$value->default_open_balance."','".$value->default_open_balance_date."','".$value->is_tax_account."','".$value->account_tax_code_id."','".$value->default_for_code."','".$value->account_protected."','".$value->created_at."','".$value->updated_at."')";
            }
        }


        if($table == "tbl_employee")
        {
            $data = Tbl_employee::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_employee (employee_id, shop_id, warehouse_id, first_name, middle_name, last_name, gender, email, username,password,b_day,position_id,date_created,archived,created_at,updated_at) VALUES " . "(".$value->employee_id.",'".$value->shop_id."','".$value->warehouse_id."','".$value->first_name."','".$value->middle_name."','".$value->last_name."','".$value->gender."','".$value->email."','".$value->username."','".$value->password."','".$value->b_day."','".$value->position_id."','".$value->date_created."','".$value->archived."','".$value->created_at."','".$value->updated_at."')";
            }
        }

        if($table == "tbl_image")
        {
            $data = Tbl_image::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_image (image_id, image_path, image_key, image_shop, image_reason, image_reason_id, image_date_created, created_at  , updated_at) VALUES " . "(".$value->image_id.",'".$value->image_path."','".$value->image_key."','".$value->image_shop."','".$value->image_reason."','".$value->image_reason_id."','".$value->image_date_created."','".$value->created_at."','".$value->updated_at."')";
            }
        }

         if($table == "tbl_inventory_serial_number")
        {
            $data = Tbl_inventory_serial_number::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_inventory_serial_number (serial_id, serial_inventory_id, item_id, serial_number, serial_created, item_count, item_consumed, sold, consume_source,consume_source_id,serial_has_been_credit,serial_has_been_debit,created_at,updated_at) VALUES " . "(".$value->serial_id.",'".$value->serial_inventory_id."','".$value->item_id."','".$value->serial_number."','".$value->serial_created."','".$value->item_count."','".$value->item_consumed."','".$value->sold."','".$value->consume_source."','".$value->consume_source_id."','".$value->serial_has_been_credit."','".$value->serial_has_been_debit."','".$value->created_at."','".$value->updated_at."')";
            }
        }

         if($table == "tbl_inventory_slip")
        {
            $data = Tbl_inventory_slip::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_inventory_slip (inventory_slip_id, inventory_slip_id_sibling, inventory_reason, warehouse_id, inventory_remarks, inventory_slip_date, archived, inventory_slip_shop_id, slip_user_id,inventory_slip_status,inventroy_source_reason,inventory_source_id,inventory_source_name,inventory_slip_consume_refill,inventory_slip_consume_cause,inventory_slip_id,created_at,updated_at) VALUES " . "(".$value->inventory_slip_id.",'".$value->inventory_slip_id_sibling."','".$value->inventory_reason."','".$value->warehouse_id."','".$value->inventory_remarks."','".$value->inventory_slip_date."','".$value->archived."','".$value->inventory_slip_shop_id."','".$value->slip_user_id."','".$value->inventory_slip_status."','".$value->inventroy_source_reason."','".$value->inventory_source_id."','".$value->inventory_source_name."','".$value->inventory_slip_consume_refill."','".$value->inventory_slip_consume_cause."','".$value->inventory_slip_id."','".$value->created_at."','".$value->updated_at."')";
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
