<?php
namespace App\Globals;

use App\Providers\Infobip_sms_api_master\Infobip_sms_api;
use App\Providers\Infobip_sms_api_master\Infobip_sms_message;

use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use File;
use Carbon\carbon;

/**
 * Branded Sms Module - all sms related module
 *
 * @author Bryan Kier Aradanas
 */

class bakit
{

}
class Sms
{
	public static function SingleText($recipient, $content)
	{
		if(is_array($recipient))
		{
			$_recipient = "";
			foreach($recipient as $key=>$number)
			{
				$key == 0 ? $_recipient .= "\"$number\"" : $_recipient .= ",\"$number\"" ;
			}
			$recipient = "[$_recipient]";
		}
		else
		{
			$recipient = "\"$recipient\"";
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{ \"from\":\"PhilTECH\", \"to\":$recipient, \"text\":\"$content.\" }",
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"authorization: Basic UGhpbFRlY2g6VEEyNTJzeGM=",
				"content-type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} 
		else {
			return $response;
		}
	}

	/**
	 * Send Notification upon |Registration
	 *
	 * @param string  	$name 	First Name of the VIP person 
	 */
	public static function sendRegistration($recipient, $name)
	{
		$text = "Hi " . $name . ",%0a" . "You have successfully completed your PhilTECH registration.For inquiries, call us at 0917-542-2614(Mobile) or at (062) 310-2256(Landline)";
		
		return Sms::SingleText($recipient, $text);
	}

	public static function sendPurchaseMembershipCode($recipient, $name, $link)
	{
		$text = "Hi " . $name . ",%0a" . "You have successfully purchased a new membership package!For further details, please log in to your account at " . $link;
		dd($text);
		// return Sms::send($recipient, $text);
	}

	public static function sendPurchaseUsingEwallet($recipient, $name, $amount)
	{
		$text = "Hi " . $name . ",%0a" . "We have already processed your order amounting to " . $amount . ".Your E-wallet account was charged upon check-out. Thank you for your purchase!";
		dd($text);
		// return Sms::send($recipient, $text);
	}

	public static function sendPurchaseUsingDiscount($recipient, $name, $start_date, $end_date)
	{
		$text = "Hi " . $name . ",%0a" . "This is to confirm your Discount Card purchase issued on " . $start_date . " and will expire on " .$end_date . " .Please be guided. Thank you!";
		dd($text);
		// return Sms::send($recipient, $text);
	}

	public static function sendPurchaseUsingCreditCard($recipient, $name, $amount)
	{
		$text = "Hi " . $name . ",%0a" . "We have already processed your order amounting to " . $amount . " . Your credit card was charged upon check-out. Thank you for your purchase!";
		dd($text);
		// return Sms::send($recipient, $text);
	}

	public static function sendPurchaseWithPayment($recipient, $name, $amount)
	{
		$text = "";
		dd($text);
		// return Sms::send($recipient, $text);
	}

	public static function limit($str, $length)
	{
		if(strlen($x)<=$length)
		{
			return $str;
		}
		else
		{
			return substr($x,0,$length) . '...';
		}
	}
}