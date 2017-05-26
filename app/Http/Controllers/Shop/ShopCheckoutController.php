<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use File;
use Input;
use Validator;
use Carbon\Carbon;
use URL;
use Session;
use DB;

use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Cart;
use App\Globals\Customer;
use App\Globals\Ec_order;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_item_code;
use App\Models\Tbl_country;
use App\Models\Tbl_online_pymnt_method;
use App\Models\Tbl_item;
use App\Models\Tbl_item_code_item;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_merchant_school;
use App\Models\Tbl_locale;
// use App\Globals\Mlm_slot_log;    

/*4/29/17 this will import the data/class needed by ipay88 payment mode by:brain*/
use App\IPay88\RequestPayment;
use App\Models\Tbl_online_pymnt_api;

class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        /* DO NOT ALLOW ON THIS PAGE IF THERE IS NOT CART */
        if (isset($data["get_cart"]['cart']) && isset($data["get_cart"]["tbl_customer"]) && isset($data["get_cart"]["tbl_customer_address"]) && isset($data["get_cart"]["tbl_ec_order"]) && isset($data["get_cart"]["tbl_ec_order_item"]) && isset($data["get_cart"]["sale_information"])) 
        {
            return view("checkout", $data);
        }
        else
        { 
            return Redirect::to('/checkout')->send();
        }
    }
    public function locale()
    {
        $parent = Request::input("parent");
        $_locale = Tbl_locale::where("locale_parent", $parent)->orderBy("locale_name")->get();

        foreach($_locale as $locale)
        {
            echo "<option value='" . $locale->locale_id . "'>" . $locale->locale_name . "</option>";
        }

    }
    public function session()
    {
        dd(Cart::get_info($this->shop_info->shop_id));
    }
    public function checkout_side()
    {
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        return view("checkout_side", $data);
    }
    public function submit()
    {
        /* SPLIT NAME TO FIRST NAME AND LAST NAME */
        $full_name = Request::input("full_name");
        $_name = $this->split_name($full_name);

        /* SET FIRST NAME, LAST NAME AND CONTACT */
        $customer_info["first_name"] = $_name[0];
        $customer_info["last_name"] = $_name[1];
        $customer_info["customer_contact"] = Request::input("contact_number");

        $customer_info["shipping_state"] = Self::locale_id_to_name(Request::input("customer_state"));
        $customer_info["shipping_city"] = Self::locale_id_to_name(Request::input("customer_city"));
        $customer_info["shipping_zip"] = Self::locale_id_to_name(Request::input("customer_zip"));
        $customer_info["shipping_street"] = Request::input("customer_street");

        $customer_set_info_response = Cart::customer_set_info($this->shop_info->shop_id, $customer_info, array("check_shipping", "check_name"));


        if($customer_set_info_response["status"] == "error")
        { 
            return Redirect::back()->with('error', $customer_set_info_response["status_message"])->withInput();
        }
        else
        {
            return Redirect::to("/checkout/payment");
        }
    }
    public function update_method()
    {
        $customer_info["method_id"] = Request::input("method_id");
        $customer_set_info_response = Cart::customer_set_info($this->shop_info->shop_id, $customer_info);
        echo json_encode("Success!"); 
    }

    public function locale_id_to_name($locale_id)
    {
        return Tbl_locale::where("locale_id", $locale_id)->pluck("locale_name");
    }
    public function payment()
    {
        if(Request::isMethod("post"))
        {
            Cart::process_payment($this->shop_info->shop_id);
        }
        else
        {
            $data["page"]            = "Checkout Payment";
            $data["_payment_method"] = $this->get_payment_method();
            $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
            return view("checkout_payment", $data);  
        }

    }

    public function get_payment_method()
    {
        $payment_method = Tbl_online_pymnt_method::leftJoin('tbl_online_pymnt_link', 'tbl_online_pymnt_link.link_method_id', '=', 'tbl_online_pymnt_method.method_id')
                                                          ->leftJoin('tbl_online_pymnt_other', 'tbl_online_pymnt_link.link_reference_id', '=', 'tbl_online_pymnt_other.other_id')
                                                          ->leftJoin('tbl_image', 'tbl_online_pymnt_link.link_img_id', '=', 'tbl_image.image_id')
                                                          ->where("tbl_online_pymnt_link.link_shop_id", $this->shop_info->shop_id)
                                                          ->where("tbl_online_pymnt_link.link_is_enabled", 1)
                                                          ->get();

        return $payment_method;
    }
    

    public function addtocart()
    {
        $data["page"] = "Checkout - Add to Cart";
        return view("addto_cart", $data);
    }

    function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }

    public function postPaymentWithIPay88()
    {
        echo "Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.";
        $shop_id = $this->shop_info->shop_id;
        $data = Cart::get_info($shop_id);
        $api = Tbl_online_pymnt_api::where('api_shop_id', $shop_id)->join("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_id", "=", "tbl_online_pymnt_api.api_gateway_id")->where("gateway_code_name", "ipay88")->first();

        $data["paymentId"] = 1; //BANCNET, CREDIT CARD, ETC
        $data["refNo"] = $this->shop_info->shop_id . time();
        $data["amount"] = $data["tbl_ec_order"]["total"];

        /* REASTRUCTURE */
        $product_summary = array();
        foreach ($data['tbl_ec_order_item'] as $key => $value) 
        {
            if ($key != count($data["cart"])) 
            {
                $product_summary = "Product #" . $value["item_id"] . " (x" . $value["quantity"] . ") - " . currency("PHP", $value["price"]) . "";
            }
            else
            {
                $product_summary = "Product #" . $value["item_id"] . " (x" . $value["quantity"] . ") - " . currency("PHP", $value["price"]) . ", ";
            }
        }

        $data["currency"] = "PHP";
        $data["prodDesc"] = $product_summary;
        $data["userName"] = $data["tbl_customer"]["first_name"] . " " . $data["tbl_customer"]["last_name"];
        $data["userEmail"] = $data["tbl_ec_order"]["customer_email"];
        $data["userContact"] = $data["tbl_customer"]["customer_contact"];
        $data["remark"] = "Remarks";
        $data["lang"] = "UTF-8";
        $data["responseUrl"] = URL::to('/ipay88_response');
        $data["backendUrl"] = URL::to('/ipay88_response');
        $data["merchantKey"] = $api->api_secret_id;
        $data["merchantCode"] = $api->api_client_id;
        $requestpayment = new RequestPayment($data["merchantKey"]);

        $this->_data = array(
            'merchantCode'  => $requestpayment->setMerchantCode($data["merchantCode"]),
            'paymentId'     => $requestpayment->setPaymentId($data["paymentId"]),
            'refNo'         => $requestpayment->setRefNo($data["refNo"]),
            'amount'        => $requestpayment->setAmount($data["amount"]),
            // 'amount'        => $requestpayment->setAmount(15),
            'currency'      => $requestpayment->setCurrency($data["currency"]),
            'prodDesc'      => $requestpayment->setProdDesc($data["prodDesc"]),
            'userName'      => $requestpayment->setUserName($data["userName"]),
            'userEmail'     => $requestpayment->setUserEmail($data["userEmail"]),
            'userContact'   => $requestpayment->setUserContact($data["userContact"]),
            'remark'        => $requestpayment->setRemark($data["remark"]),
            'lang'          => $requestpayment->setLang($data["lang"]),
            'signature'     => $requestpayment->getSignature(),
            'responseUrl'   => $requestpayment->setResponseUrl($data["responseUrl"]),
            'backendUrl'    => $requestpayment->setBackendUrl($data["backendUrl"])
        );

        RequestPayment::make($data["merchantKey"], $this->_data);     
    }

    public function ipay88_response()
    {
        $request = Request::all();
        $shop_id = $this->shop_info->shop_id;

        if ($request) 
        {
            // LOGS
            $ipay88_logs["log_merchant_code"] = $request['MerchantCode'];
            $ipay88_logs["log_payment_id"] = $request['PaymentId'];
            $ipay88_logs["log_reference_number"] = $request['RefNo'];
            $ipay88_logs["log_amount"] = $request['Amount'];
            $ipay88_logs["log_currency"] = $request['Currency'];
            $ipay88_logs["log_remarks"] = $request['Remark'];
            $ipay88_logs["log_trans_id"] = $request['TransId'];
            $ipay88_logs["log_auth_code"] = $request['AuthCode'];
            $ipay88_logs["log_status"] = $request['Status'];
            $ipay88_logs["log_error_desc"] = $request['ErrDesc'];
            $ipay88_logs["log_signature"] = $request['Signature'];
            $ipay88_logs["shop_id"] = $this->shop_info->shop_id;

            DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

            if($request['Status'] == 0)
            {
                dd($request['ErrDesc'].'. '.'Please refer to ipay88 Appendix I - 3.0 Error Description.');
                // return redirect('/checkout')->withErrors($request['ErrDesc'].'. '.'Please refer to ipay88 Appendix I - 3.0 Error Description.')->send();    
            } 
            else 
            {
                $shop_id        = $this->shop_info->shop_id;
                $payment_status = 1;
                $order_status   = "Processing";

                $order_id = Cart::submit_order($shop_id, $payment_status, $order_status, Self::$customer_info ? Self::$customer_info->customer_id : null);
                Cart::clear_all($this->shop_info->shop_id);

                // Redirect
                return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($order_id)))->send();
            }
        }
        else
        {
            return Redirect::to("/checkout")->with('fail', 'Session has been expired. Please try again.')->send();
        }
    }

    public function order_placed()
    {
        $data["page"] = "Checkout - Order Placed";
        $order = Request::input('order');
        if (!$order) 
        {
            return Redirect::to("/");
        }

        $order_id = unserialize(Crypt::decrypt($order));
    
        $data['_order'] = Tbl_ec_order_item::where("ec_order_id", $order_id)
                                           ->leftJoin('tbl_ec_variant', 'tbl_ec_order_item.item_id', '=', 'evariant_id')
                                           ->get();

        $data['summary'] = [];
        $subtotal = 0;
        $shipping = 0;
        $total = 0;

        foreach ($data['_order'] as $key => $value) 
        {
            $subtotal += $value->total;
        }
        
        $data['summary']['subtotal'] = $subtotal;
        $data['order_id'] = $order_id;

        return view("order_placed", $data);
    }
}
