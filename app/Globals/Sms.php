<?php
namespace App\Globals;
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

class Sms
{
	public static function Send($recipient, $content)
	{
		File::requireOnce('assets/libraries/Infobip_sms_api-master/Infobip_sms_api.php');

		$infobip = new Infobip_sms_api();

		// infobip username
		$infobip->setUsername('username'); 
		// infobip password
		$infobip->setPassword('password'); 

		$infobip->setMethod(Infobip_sms_api::OUTPUT_XML);
		$infobip->setMethod(Infobip_sms_api::OUTPUT_JSON);
		$infobip->setMethod(Infobip_sms_api::OUTPUT_PLAIN);

		$message = new Infobip_sms_message();

		$message->setSender('Philtech');
		$message->setText($content);
		$message->setRecipients($recipient);

		$infobip->addMessages(array($message));

		$results = $infobip->sendSMS();

		return $results;
	}

	/**
	 * Send Notification upon |Registration
	 *
	 * @param string  	$name 	First Name of the VIP person 
	 */
	public static function sendRegistration($recipient, $name)
	{
		$text = "Hi " . $name . ",%0a" . "You have successfully completed your PhilTECH registration.For inquiries, call us at 0917-542-2614(Mobile) or at (062) 310-2256(Landline)";
		dd($text);
		// return Sms::send($recipient, $text);
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