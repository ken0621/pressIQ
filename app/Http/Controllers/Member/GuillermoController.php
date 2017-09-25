<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_customer;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_user;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_online_pymnt_method;
use App\Models\Tbl_email_template;
use App\Models\Tbl_online_pymnt_api;
use App\Models\Tbl_mlm_slot;
use App\Globals\Ecom_Product;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Globals\Mlm_discount;
use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_item_points;
use App\Globals\Mlm_plan;
use Crypt;
use Config;
use URL;
use Request;
use App\Globals\Mlm_slot_log;
// IPAY 88
use App\IPay88\RequestPayment;
// DRAGON PAY
use App\Globals\Dragonpay2\Dragon_RequestPayment;
// PAYMAYA
use App\Globals\PayMaya\PayMayaSDK;
use App\Globals\PayMaya\API\Checkout;
use App\Globals\PayMaya\API\Customization;
use App\Globals\PayMaya\API\Webhook;
use App\Globals\PayMaya\Core\CheckoutAPIManager;
use App\Globals\PayMaya\Checkout\User;
use App\Globals\PayMaya\Model\Checkout\ItemAmountDetails;
use App\Globals\PayMaya\Model\Checkout\ItemAmount;

class GuillermoController extends Controller
{
    function __construct()
    {
        $order = DB::table("tbl_ec_order")->where("payment_status", 1)->where("archived", 0)->where("invoice_number", NULL)->get();
        foreach ($order as $key => $value) 
        {
            $last = DB::table("tbl_ec_order")->where("payment_status", 1)->where("archived", 0)->max("invoice_number");
            if ($last) 
            {
                $update["invoice_number"] = $last + 1;
                DB::table('tbl_ec_order')->where("ec_order_id", $value->ec_order_id)->update($update);            
            }
            else
            {
                $update["invoice_number"] = 11000000;
                DB::table('tbl_ec_order')->where("ec_order_id", $value->ec_order_id)->update($update);
            }
        }
    }
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
	            $response_array = @unserialize($order->response);
	            
	            if(isset($response_array["requestReferenceNumber"]))
	            {
	                $request_number = $response_array["requestReferenceNumber"] . " - <span style='color: #ccc'>" . date("F d, Y - h:i:a", strtotime($order->created_date)) . "</span>";
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
	public function payref()
	{
	    $_order = $data["_order"] = DB::table("tbl_ec_order")
	                                                           ->join("tbl_paymaya_logs", "tbl_paymaya_logs.order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_customer", "tbl_customer.customer_id", "=", "tbl_ec_order.customer_id")
	                                                           ->leftJoin("tbl_ec_order_slot", "tbl_ec_order_slot.order_slot_ec_order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_mlm_slot", "tbl_mlm_slot.slot_id", "=", "tbl_ec_order_slot.order_slot_id_c")
	                                                           ->leftJoin("tbl_customer_address", "tbl_customer_address.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->leftJoin("tbl_customer_other_info", "tbl_customer_other_info.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->groupBy("ec_order_id")
	                                                          // ->where("ec_order_id", ">", "480")
	                                                           ->orderBy("ec_order_id", "asc")
	                                                           ->get();
	    
	    //dd($_order);
	    return view("guillermo.payref", $data);
	}
	public function payref2()
	{
	    $_order = $data["_order"] = DB::table("tbl_ec_order")
	                                                           ->join("tbl_paymaya_logs", "tbl_paymaya_logs.order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_customer", "tbl_customer.customer_id", "=", "tbl_ec_order.customer_id")
	                                                           ->leftJoin("tbl_ec_order_slot", "tbl_ec_order_slot.order_slot_ec_order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_mlm_slot", "tbl_mlm_slot.slot_id", "=", "tbl_ec_order_slot.order_slot_id_c")
	                                                           ->leftJoin("tbl_customer_address", "tbl_customer_address.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->leftJoin("tbl_customer_other_info", "tbl_customer_other_info.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->groupBy("ec_order_id")
	                                                          // ->where("ec_order_id", ">", "480")
	                                                           ->orderBy("ec_order_id", "asc")
	                                                           ->get();
	    

	    return view("guillermo.payref2", $data);
	}
	public function draref()
	{
	    $_order = $data["_order"] = DB::table("tbl_ec_order")
	                                                           ->join("tbl_dragonpay_logs", "tbl_dragonpay_logs.order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_customer", "tbl_customer.customer_id", "=", "tbl_ec_order.customer_id")
	                                                           ->leftJoin("tbl_ec_order_slot", "tbl_ec_order_slot.order_slot_ec_order_id", "=", "tbl_ec_order.ec_order_id")
	                                                           ->leftJoin("tbl_mlm_slot", "tbl_mlm_slot.slot_id", "=", "tbl_ec_order_slot.order_slot_id_c")
	                                                           ->leftJoin("tbl_customer_address", "tbl_customer_address.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->leftJoin("tbl_customer_other_info", "tbl_customer_other_info.customer_id", "=", "tbl_customer.customer_id")
	                                                           ->groupBy("ec_order_id")
	                                                          // ->where("ec_order_id", ">", "480")
	                                                           ->orderBy("ec_order_id", "asc")
	                                                           ->get();
	    
	    //dd($_order);
	    return view("guillermo.draref", $data);
	}
	public function payref_check($checkout_id)
	{
	    $api = Tbl_online_pymnt_api::where('api_shop_id', 5)->join("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_id", "=", "tbl_online_pymnt_api.api_gateway_id")->where("gateway_code_name", "paymaya")->first();
		
		if (get_domain() == "c9users.io") 
        {
            $url = "https://pg-sandbox.paymaya.com/checkout/v1/checkouts/$checkout_id";
        }
        else
        {
            $url = "https://api.paymaya.com/checkout/v1/checkouts/$checkout_id";
        }
        
		
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        $authorization = base64_encode($api->api_secret_id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Basic $authorization"
        ));
        
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
      
      
        
      
        if(Request::input("debug") == "yes")
        {
            dd($response);
        }
        
        if($response == null)
        {
            $data["response"] = "Error";
            $data["information"] = "PAYMAYA DID'T RETURN ANYTHING";
        }
        elseif(isset($response->error))
        {
            $data["response"] = "Error";
            $data["information"] = $response->error->code;
        }
        else
        {
            $data["response"] = $response->paymentStatus;
            if($response->paymentStatus == "PAYMENT_SUCCESS")
            {
                $data["information"] = "PAID with " . $response->paymentDetails->cardType ." ending in " . $response->paymentDetails->last4;
            }
            else
            {
                if(isset($response->paymentDetails))
                {
                    if(isset($response->paymentDetails->cardType))
                    {
                        $data["information"] = "Tried to pay using " . $response->paymentDetails->cardType ." ending in " . $response->paymentDetails->last4;
                    }
                    else
                    {
                        $data["information"] = "Data is not accessible.";
                    }
                    
                }
                else
                {
                    $data["information"] = "No transaction details provided.";
                }
            }
            
        }


        $order_id = Request::input("order_id");
        $update["confirm_response"] = $data["response"];
        $update["confirm_response_information"] = $data["information"];
        $update["confirm_response_array"] = serialize($response);
        DB::table("tbl_paymaya_logs")->where("order_id", $order_id)->update($update);

        echo json_encode($data);
        
        

	}
	public function webhook()
	{
		$api = Tbl_online_pymnt_api::where('api_shop_id', 5)->join("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_id", "=", "tbl_online_pymnt_api.api_gateway_id")->where("gateway_code_name", "paymaya")->first();
		
		if (get_domain() == "c9users.io") 
        {
            PayMayaSDK::getInstance()->initCheckout('pk-PUQUwFiIyco5xTRpUldYGyEv0aM6YNd2CHvbPVZiang', 'sk-eLb6ixXV5l4KqV4tOnrm4qiz3Nvpv4InKj6OAEaAIpY', "SANDBOX");
        }
        else
        {
            PayMayaSDK::getInstance()->initCheckout($api->api_client_id, $api->api_secret_id, "PRODUCTION");   
        }
        
        
		$webhook = Webhook::retrieve();
		
        if (isset($webhook) && $webhook && count($webhook) > 0) 
        {
            foreach ($webhook as $value) 
            {
                if ($value->name == "CHECKOUT_SUCCESS") 
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_SUCCESS;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/success");
                    $updateWebhook->delete();
                }
                elseif($value->name == "CHECKOUT_FAILURE")
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_FAILURE;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/failure");
                    $updateWebhook->delete();
                }
                elseif($value->name == "CHECKOUT_DROPOUT")
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_DROPOUT;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/cancel");
                    $updateWebhook->delete();
                }
            }
        }
        
        $successWebhook = new Webhook();
        $successWebhook->name = Webhook::CHECKOUT_SUCCESS;
        $successWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/success");
        $successWebhook->register();
        
        $failureWebhook = new Webhook();
        $failureWebhook->name = Webhook::CHECKOUT_FAILURE;
        $failureWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/failure");
        $failureWebhook->register();
        
        $cancelWebhook = new Webhook();
        $cancelWebhook->name = Webhook::CHECKOUT_DROPOUT;
        $cancelWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/cancel");
        $cancelWebhook->register();
        
        dd(Webhook::retrieve());
	}
}