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
        if($table == "shop")
        {
            $data = Tbl_shop::get();
            foreach ($data as $key => $value) 
            {
                $return[$key] = "INSERT INTO tbl_shop (shop_id, shop_key, shop_date_created, shop_date_expiration, shop_last_active_date, shop_status, shop_country, shop_city, shop_zip, shop_street_address, shop_contact, url, shop_domain, shop_theme, shop_theme_color, member_layout, shop_wallet_tours, shop_wallet_tours_uri, shop_merchant_school, created_at, updated_at) VALUES " . "(".$value->shop_id.",'".$value->shop_key."','".$value->shop_date_created."','".$value->shop_date_expiration."','".$value->shop_last_active_date."','".$value->shop_status."','".$value->shop_country."','".$value->shop_city."','".$value->shop_zip."','".$value->shop_street_address."','".$value->shop_contact."','".$value->url."','".$value->shop_domain."','".$value->shop_theme."','".$value->shop_theme_color."','".$value->member_layout."','".$value->shop_wallet_tours."','".$value->shop_wallet_tours_uri."','".$value->shop_merchant_school."','".$value->created_at."','".$value->updated_at."')";
            }
        }
        if($table == "category")
        {
            $data = Tbl_category::get();
            foreach ($data as $key => $value) 
            {
                // $return[$key] = "INSERT INTO tbl_category (shop_id, shop_key, shop_date_created, shop_date_expiration, shop_last_active_date, shop_status, shop_country, shop_city, shop_zip, shop_street_address, shop_contact, url, shop_domain, shop_theme, shop_theme_color, member_layout, shop_wallet_tours, shop_wallet_tours_uri, shop_merchant_school) VALUES " . "(".$value->shop_id.",'".$value->shop_key."','".$value->shop_date_created."','".$value->shop_date_expiration."','".$value->shop_last_active_date."','".$value->shop_status."','".$value->shop_country."','".$value->shop_city."','".$value->shop_zip."','".$value->shop_street_address."','".$value->shop_contact."','".$value->url."','".$value->shop_domain."','".$value->shop_theme."','".$value->shop_theme_color."','".$value->member_layout."','".$value->shop_wallet_tours."','".$value->shop_wallet_tours_uri."','".$value->shop_merchant_school."')";
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
