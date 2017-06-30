<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Globals\Cart;
use Crypt;
use DB;

class GuillermoController extends Controller
{
	public function index($id)
	{
	    echo Crypt::decrypt($id);
	}
	public function cross()
	{
	    $_order = DB::table("tbl_ec_order")->join("tbl_paymaya_logs_other", "tbl_paymaya_logs_other.order_id", "=", "tbl_ec_order.ec_order_id")->get();
	    
	    foreach($_order as $order)
	    {
	        if($order->response)
	        {
	            $response_array = unserialize($order->response);
	            if(isset($response_array["requestReferenceNumber"]))
	            {
	                $request_number = $response_array["requestReferenceNumber"];
	            }
	            else
	            {
	                $request_number = "BLANK";
	            }
	            
	            
	            if($request_number != $order->ec_order_id)
	            {
	                $request_number = "<span style='color:red;'> " . $request_number . " </span>";
	            }
	            
	            echo $order->ec_order_id . " ($request_number)" . "<br>";
	        }
	        
	    }
	}
}