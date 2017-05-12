<?php

namespace App\Http\Controllers\Member;

use Request;
use Session;
use App\Http\Controllers\Controller;
use App\Models\Tbl_audit_trail;
use App\Models\Tbl_user;
use DB;

use App\Globals\AuditTrail;
use App\Globals\Utilities;
class AuditTrailController extends Member
{
    public function hasAccess($page_code, $acces)
    {
        $access = Utilities::checkAccess($page_code, $acces);
        if($access == 1) return true;
        else return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data["_column"] = array(
                ' '                     => "*", 
                //'fullname'              => "Full Name", 
                'fname'                 => "User First Name",
                'lname'                 => "User Last Name", 
                'remarks'               => "Transaction", 
                /*'transaction_client'    => "Desription", */
            );

        /* $sample = Tbl_audit_trail::join('tbl_user', 'tbl_user.user_id', '=', 'tbl_audit_trail.user_id')
                    ->where(DB::raw("CONCAT('tbl_user.user_first_name', ' ', 'tbl_user.user_last_name')"), "LIKE", "%Sample%")->get();
         dd($sample);
*/
        if($this->hasAccess("utilities-audit","access_page"))
        {   
            $data["_audit"] = AuditTrail::getAudit_data();
        
            if (Request::isMethod('post'))
            {
                
                $data["date_from"]  = Request::input('date_from');
                $data["date_to"]    = Request::input('date_to');
                $data["col"]        = Request::input('col');
                $data['keyword']    = Request::input('keyword');
                //dd($data['keyword']);

                if ($data["date_from"] != '' && $data["date_from"] != '')
                {
                    $data["_audit"] = AuditTrail::getSearchAuditData($data["col"], $data['keyword'], $data["date_from"], $data["date_to"]);
                }
                    else
                {
                    $data["_audit"] = AuditTrail::getSearchAuditData($data["col"], $data['keyword']);    
                }
                                    
            }

            //dd(Session::get('date_from'));
            return view("member.audit_trail.audit_trail",$data);
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
