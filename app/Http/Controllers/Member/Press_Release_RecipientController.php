<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use Session;
use Redirect;
use Request;
use Response;
use Input;
use App\Models\Tbl_shop;
use App\Models\Tbl_press_release_email;
use App\Models\Tbl_press_release_recipient;
use App\Models\Tbl_press_release_email_sent;
use Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Globals\Settings;
use URL;

class Press_Release_Controller extends Member
{
    
    public function inport_recipient_list(Request $request)
    {
        if($request->hasFile('recipient_list')){
            Excel::load($request->file('recipient_list')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    $data['title'] = $row['title'];
                    $data['description'] = $row['description'];

                    if(!empty($data)) {
                        DB::table('post')->insert($data);
                    }
                }
            });
        }

        Session::put('success', 'Youe file successfully import in database!!!');

        return back();
    }
}