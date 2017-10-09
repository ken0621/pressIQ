<?php
namespace App\Http\Controllers;

class LeadController extends Controller
{
    public function ref($slot_no)
    {
        $store["lead_sponsor"] = $slot_no;
        session($store);
        return redirect("/");
    }
}