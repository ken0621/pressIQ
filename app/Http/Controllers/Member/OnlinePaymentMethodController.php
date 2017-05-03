<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Models\Tbl_online_pymnt_method;
use App\Models\Tbl_online_pymnt_gateway;
use App\Models\Tbl_online_pymnt_api;
use App\Models\Tbl_online_pymnt_other;
use App\Models\Tbl_online_pymnt_link;
use App\Models\Tbl_user;

use Request;
use DB;
use Crypt;
use Carbon\Carbon;
use Session;
use Redirect;

class OnlinePaymentMethodController extends Member
{
	public function getList()
	{
		
	}

	public function getIndex()
	{
		$data["_method"] 	= Tbl_online_pymnt_method::link($this->getShopId())->get();
		foreach($data["_method"] as $key=>$method)
		{
			$data["_method"][$key] 			= $method;
			$data["_method"][$key]->gateway = $this->filterPaymentGateway($method->method_id);
		}
		// dd($data["_method"] );
		$data["_gateway"] 	= $this->gatewayInfo();
		// dd($data);
		return view('member.online_payment.payment', $data);
	}

	public function gatewayInfo()
	{
		$_gateway = Tbl_online_pymnt_gateway::gatewayApi($this->getShopId())->get();
		foreach($_gateway as $key=>$gateway)
		{
			$_gateway[$key] = $gateway;
			if($gateway->gateway_code_name == 'other')
			{
				$_gateway[$key]->other = Tbl_online_pymnt_other::where('other_shop_id', $this->getShopId())->get();
			}
			else
			{
				$_gateway[$key]->client_id = $gateway->api_client_id;
				$_gateway[$key]->secret_id = $gateway->api_secret_id;
			}
		}
		// dd($_gateway);
		return $_gateway;
	}

	public function getOtherInfo()
	{
		$other_id = Request::input('id');
		$data = [];
		if($other_id)
		{
			$data["other"] = Tbl_online_pymnt_other::where("other_id", $other_id)->first();
		}

		return view('member.online_payment.load_other_info', $data);
		
	}

	public function postSaveGateway()
	{
		// dd(Request::input());
		$gateway_code = Request::input('gateway_code_name');

		$data["api_shop_id"] 	= $this->getShopId();
		$data["api_gateway_id"] = Request::input('api_gateway_id');
		$data["api_client_id"] 	= Request::input('api_client_id');
		$data["api_secret_id"] 	= Request::input('api_secret_id');

		$api_id = Tbl_online_pymnt_api::where("api_shop_id", $data["api_shop_id"])->where("api_gateway_id", $data["api_gateway_id"])->pluck("api_id");

		if($api_id)
		{
			Tbl_online_pymnt_api::where("api_id", $api_id)->update($data);
		}
		else
		{
			$api_id = Tbl_online_pymnt_api::insertGetId($data);
		}

		$json["status"] = "success";
		$json["type"]	= "api";
		$json["api_id"]	= $api_id;

		return json_encode($json);
	}

	public function postSaveGatewayOther()
	{
		$other_id = Request::input('other_id');
		// dd($other_id);
		$data["other_shop_id"]			= $this->getShopId();
		$data["other_gateway_id"]		= 5;
		$data["other_name"] 			= Request::input('other_name');
		$data["other_description"] 		= Request::input('other_description');

		if($other_id != null)
		{
			Tbl_online_pymnt_other::where("other_id", $other_id)->update($data);
		}
		else
		{
			$other_id = Tbl_online_pymnt_other::insertGetId($data);
		}

		$json["status"]		= "success";
		$json["type"]		= "other";
		$json["other_id"]	= $other_id;

		return json_encode($json);
	}

	public function load_payment_gateway($id)
	{
		$data["_gateway"] = $this->filterPaymentGateway($id);

		return view('member.load_ajax_data.load_payment_gateway', $data);
	}

	public function filterPaymentGateway($id)
	{
		$method 	= Tbl_online_pymnt_method::where("method_id",$id)->pluck("method_gateway_accepted");
		$_method	= explode(",",$method);

		$_gateway		= Tbl_online_pymnt_gateway::unionGateway($this->getShopId(), $_method)->get();

		// DD($_method);
		// dd($_gateway);
		return $_gateway;
	}

	public function postSavePaymentSetting()
	{
		// dd(Request::input());

		$link_id = Tbl_online_pymnt_link::where("link_method_id", Request::input('link_method_id'))->where("link_shop_id", $this->getShopId())->first();

		// dd(Request::input());
		$data["link_shop_id"] 			= $this->getShopId();
		$data["link_method_id"] 		= Request::input('link_method_id');
		$data["link_reference_name"] 	= Request::input('link_reference_name');
		$data["link_reference_id"] 		= Request::input('link_reference_id');
		$data["link_img_id"] 			= Request::input('link_img_id');
		$data["link_is_enabled"] 		= Request::input('link_is_enabled') == 'on' ? 1 : 0;

		if($link_id != null)
		{
			Tbl_online_pymnt_link::where("link_id", $link_id->link_id)->update($data);
		}
		else
		{
			$link_id = Tbl_online_pymnt_link::insertGetId($data);
		}

		$json["status"]	= "success";
		$json["type"]	= "link";
		$json["link_id"]= $link_id;

		return json_encode($json);
	}

	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}
}