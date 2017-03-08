<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;

use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_unit_measurement_type;
use App\Globals\UnitMeasurement;
use App\Globals\Utilities;
use Carbon\Carbon;
use Validator;
class UnitOfMeasurementController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function index()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["_um"] = Tbl_unit_measurement::where("um_archived",0)
                                                        ->groupBy("tbl_unit_measurement.um_id")
                                                        ->get();
            foreach ($data["_um"] as $key => $value) 
            {
                $multi = Tbl_unit_measurement_multi::where("multi_um_id",$value->um_id)->get();
                foreach ($multi as $key1 => $value1) 
                {
                    if($value1->is_base == 1)
                    {
                        $data["_um"][$key]->um_base_name = $value1->multi_name;
                        $data["_um"][$key]->um_base_abbrev = $value1->multi_abbrev;
                    }                
                }
            }
            // dd($data["_um"]);
            return view("member.unit_of_measurement.unit_measurement",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function select_um()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $unit_id = Request::input("unit_id");

            $data = UnitMeasurement::select_um($unit_id,'json');

            return $data;
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function load_um()     
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["_um"] = UnitMeasurement::load_um();

            return view('member.load_ajax_data.load_unit_measurement', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function load_one_um($um_id)     
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["_um"] = UnitMeasurement::load_one_um($um_id);

            return view('member.load_ajax_data.load_one_unit_measure', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["_um_type"] = Tbl_unit_measurement_type::where("um_type_parent_id",0)->where("archived",0)->get();

            return view("member.unit_of_measurement.unit_measurement_add",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function add_submit()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["status_message"] = "";
            $data["status"] = "";

            $set_name = Request::input("um_set_name");
            $base_name = Request::input("base_name");
            $base_abbrev = Request::input("base_abbreviation");
            $um_type = Request::input("um_type");

            $related = Request::input("related_name");
            $abbrev = Request::input("related_abb");
            $qty = Request::input("related_qty");

            $insert["um_name"] = $set_name;
            // $insert["um_base_name"] = $base_name;
            // $insert["um_base_abbrev"] = $base_abbrev;
            $insert["um_date_created"] = Carbon::now();
            $insert["um_shop"] = $this->user_info->shop_id;
            $insert["um_type"] = $um_type;

            $rule["um_name"]            = "required|unique:tbl_unit_measurement,um_name";
            // $rule["um_base_name"]       = "required";
            // $rule["um_base_abbrev"]     = "required";
            $rule["um_type"]            = "";

            $validator = Validator::make($insert,$rule);
            if(Request::input("um_type_type") == null)
            {
                $data["status"] = "error";
                $data["status_message"] .= "Please select the type of measurement."; 
            }
            else
            {
                if(Request::input("um_type_type") != "selected_other")
                {
                    if(Request::input("um_child_type") == null)
                    {
                        $data["status"] = "error";
                        $data["status_message"] .= "Please select a base unit of measurement.";                 
                    }                
                }
            }
            if($validator->fails())
            {
                $data["status"] = "error";
                foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                {
                    $data["status_message"] .= $message;
                }
            }
            else
            {
                $rule = "";
                if($related != null && $abbrev != null & $qty != null)
                {
                    $ins_related["multi_name"] = $base_name;
                    $ins_related["multi_abbrev"] = $base_abbrev;
                    $ins_related["unit_qty"] = 1;

                    $rule["multi_name"]    = "required";
                    $rule["multi_abbrev"]  = "required";
                    $rule["unit_qty"]      = "required|numeric|min:1";

                    $validator3 = Validator::make($ins_related, $rule);
                    if($validator3->fails())
                    {
                        $data["status"] = "error";
                        foreach ($validator3->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                        {
                            $data["status_message"] .= $message;
                        }
                    }
                    else
                    {
                        $ins_related = "";
                        foreach ($related as $key => $value) 
                        {
                            if($value != "")
                            {
                                $ins_related[$key]["multi_name"] = $value;
                                $ins_related[$key]["multi_abbrev"] = $abbrev[$key];
                                $ins_related[$key]["unit_qty"] = str_replace(",", "", $qty[$key]);

                                $rule[$key]["multi_name"]    = "required";
                                $rule[$key]["multi_abbrev"]  = "required";
                                $rule[$key]["unit_qty"]      = "required|numeric|min:1";

                                $validator2[$key] = Validator::make($ins_related[$key], $rule[$key]);
                                if($validator2[$key]->fails())
                                {
                                    $data["status"] = "error";
                                    foreach ($validator2[$key]->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                                    {
                                        $data["status_message"] .= $message;
                                    }
                                }

                            }
                        }
                    }
                }
                $ins_related = "";
                if($data["status"] == "")
                {
                    $id = Tbl_unit_measurement::insertGetId($insert);
                    
                    $ins_related["multi_um_id"] = $id;
                    $ins_related["multi_name"] = $base_name;
                    $ins_related["multi_abbrev"] = $base_abbrev;
                    $ins_related["unit_qty"] = 1;
                    $ins_related["is_base"] = 1;

                    Tbl_unit_measurement_multi::insert($ins_related);
                    $ins_related = null;
                    if($related != null && $abbrev != null && $qty != null)
                    {
                        foreach ($related as $keys => $value) 
                        {
                            if($value != "")
                            {
                                $ins_related["multi_um_id"] = $id;
                                $ins_related["multi_name"] = $value;
                                $ins_related["multi_abbrev"] = $abbrev[$keys];
                                $ins_related["unit_qty"] = str_replace(",", "", $qty[$keys]); 

                                Tbl_unit_measurement_multi::insert($ins_related);                   
                            }
                        }
                    }
                    $data["status"] = "success";
                    $data["type"] = "unit-measurement";
                    $data["id"] = $id;
                }
            }
            
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }

    }

    public function edit($id)
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["_um_type"] = Tbl_unit_measurement_type::where("um_type_parent_id",0)->where("archived",0)->get();

            $data["edit_um"] = Tbl_unit_measurement::where("um_id",$id)->first();
            $multi_base = Tbl_unit_measurement_multi::where("multi_um_id",$id)->where("is_base",1)->first();
            $data["edit_um"]->um_base_name = $multi_base->multi_name;
            $data["edit_um"]->um_base_abbrev = $multi_base->multi_abbrev;
            $data["_multi"] = Tbl_unit_measurement_multi::where("multi_um_id",$id)->where("is_base",0)->get();

            return view("member.unit_of_measurement.unit_measurement_edit",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function edit_submit()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $data["status_message"] = "";
            $data["status"] = "";

            $um_id = Request::input("um_id");
            $set_name = Request::input("um_set_name");
            $base_name = Request::input("base_name");
            $base_abbrev = Request::input("base_abbreviation");

            $related = Request::input("related_name");
            $abbrev = Request::input("related_abb");
            $qty = Request::input("related_qty");
            $multi_id = Request::input("multi_id");

            $insert["um_name"] = $set_name;
            // $insert["um_base_name"] = $base_name;
            // $insert["um_base_abbrev"] = $base_abbrev;
            $insert["um_date_created"] = Carbon::now();
            $insert["um_shop"] = $this->user_info->shop_id;

            $rule["um_name"]            = "required|unique:tbl_unit_measurement,um_name,".$um_id.",um_id";
            // $rule["um_base_name"]       = "required|unique:tbl_unit_measurement,um_base_name,".$um_id.",um_id";
            // $rule["um_base_abbrev"]     = "required|unique:tbl_unit_measurement,um_base_abbrev,".$um_id.",um_id";
            $rule["um_type"]            = "";

            $validator = Validator::make($insert,$rule);

            $multi_id_first = null;

            $multi_id_first = Tbl_unit_measurement_multi::where("is_base",1)->where("multi_um_id",$um_id)->pluck("multi_id");

            if($validator->fails())
            {
                $data["status"] = "error";
                foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                {
                    $data["status_message"] .= $message;
                }
            }
            else
            {
                $rule = "";
                if($related != null && $abbrev != null & $qty != null)
                {
                    $ins_related["multi_um_id"] = $um_id;
                    $ins_related["multi_name"] = $base_name;
                    $ins_related["multi_abbrev"] = $base_abbrev;
                    $ins_related["unit_qty"] = 1;

                    $rule["multi_name"]    = "required";
                    $rule["multi_abbrev"]  = "required";
                    $rule["unit_qty"]      = "required|numeric|min:1";

                    $validator3 = Validator::make($ins_related, $rule);
                    if($validator3->fails())
                    {
                        $data["status"] = "error";
                        foreach ($validator3->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                        {
                            $data["status_message"] .= $message;
                        }
                    }
                    else
                    {
                        foreach ($related as $key => $value) 
                        {
                            if($value != "")
                            {
                                $ins_related[$key]["multi_name"] = $value;
                                $ins_related[$key]["multi_abbrev"] = $abbrev[$key];
                                $ins_related[$key]["unit_qty"] =str_replace(",", "", $qty[$key]);;

                                if(isset($multi_id[$key]))
                                {
                                    $data = Tbl_unit_measurement_multi::where("multi_id",$multi_id[$key])->first();                            
                                    $rule[$key]["multi_name"]    = "required";
                                    $rule[$key]["multi_abbrev"]  = "required";
                                    $rule[$key]["unit_qty"]      = "required|numeric|min:1";
                                }
                                else
                                {                            
                                    $rule[$key]["multi_name"]    = "required";
                                    $rule[$key]["multi_abbrev"]  = "required";
                                    $rule[$key]["unit_qty"]      = "required|numeric";
                                }

                                $validator2[$key] = Validator::make($ins_related[$key], $rule[$key]);
                                if($validator2[$key]->fails())
                                {
                                    $data["status"] = "error";
                                    foreach ($validator2[$key]->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                                    {
                                        $data["status_message"] .= $message;
                                    }
                                }

                            }
                        }
                    }
                }
                $ins_related = "";
                if($data["status"] == "")
                {
                    Tbl_unit_measurement::where("um_id",$um_id)->update($insert);

                    $ins_related["multi_name"] = $base_name;
                    $ins_related["multi_abbrev"] = $base_abbrev;

                    Tbl_unit_measurement_multi::where("multi_id",$multi_id_first)->update($ins_related);
                    $ins_related = "";
                    if($related != null && $abbrev != null && $qty != null)
                    {
                        foreach ($related as $keys => $value) 
                        {
                            if($value != "")
                            {
                                if(isset($multi_id[$keys]))
                                {
                                    $data = Tbl_unit_measurement_multi::where("multi_id",$multi_id[$keys])->first();
                                    if($data != null)
                                    {
                                        $ins_related["multi_um_id"] = $um_id;
                                        $ins_related["multi_name"] = $value;
                                        $ins_related["multi_abbrev"] = $abbrev[$keys];
                                        $ins_related["unit_qty"] = str_replace(",", "", $qty[$keys]);; 

                                        Tbl_unit_measurement_multi::where("multi_id",$multi_id[$keys])->update($ins_related);                                
                                    }
                                }
                                else
                                {
                                    $ins_related["multi_um_id"] = $um_id;
                                    $ins_related["multi_name"] = $value;
                                    $ins_related["multi_abbrev"] = $abbrev[$keys];
                                    $ins_related["unit_qty"] = str_replace(",", "", $qty[$keys]);; 

                                    Tbl_unit_measurement_multi::insert($ins_related);                                
                                }
                            }
                        }
                    }
                    $data["status"] = "success";
                }
            }
            
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }

    }
    public function select_type()
    {
        $access = Utilities::checkAccess('item-unit-measurement', 'access_page');
        if($access == 1)
        {
            $type_id = Request::input("type_id");

            $data = Tbl_unit_measurement_type::where("um_type_parent_id",$type_id)->get();

            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
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
