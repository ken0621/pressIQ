<?php

namespace App\Http\Controllers\Member;

use Request;
use DB;
use Crypt;
use Carbon\Carbon;
use Session;
use App\Http\Controllers\Controller;

class MailSettingController extends Member
{
    public function index()
    {
        return view("member.settings.mail_setting");
    }
}
