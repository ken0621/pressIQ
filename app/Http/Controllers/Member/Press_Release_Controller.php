<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use Session;
use Redirect;
use Request;
use Response;
use Input;
use App\Models\Tbl_shop;
use App\Models\Tbl_partners;
use App\Globals\Utilities;
use App\Globals\AuditTrail;

class Press_Release_Controller extends Member
{
    
    public function press_create_email()
    {
    	return view("member.email_system.email_login");
    }





}