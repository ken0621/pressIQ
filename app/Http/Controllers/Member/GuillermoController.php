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
	public function webhook()
	{
		$api = Tbl_online_pymnt_api::where('api_shop_id', 5)->join("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_id", "=", "tbl_online_pymnt_api.api_gateway_id")->where("gateway_code_name", "paymaya")->first();
		
		if (get_domain() == "c9users.io") 
        {
            PayMayaSDK::getInstance()->initCheckout($api->api_client_id, $api->api_secret_id, "SANDBOX");
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
                    $updateWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/paymaya/failure");
                    $updateWebhook->delete();
                }
                elseif($value->name == "CHECKOUT_DROPOUT")
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_DROPOUT;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/paymaya/cancel");
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
        $failureWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/paymaya/failure");
        $failureWebhook->register();
        
        $cancelWebhook = new Webhook();
        $cancelWebhook->name = Webhook::CHECKOUT_DROPOUT;
        $cancelWebhook->callbackUrl = URL::to("/payment/paymaya/webhook/paymaya/cancel");
        $cancelWebhook->register();
        
        dd(Webhook::retrieve());
	}
}