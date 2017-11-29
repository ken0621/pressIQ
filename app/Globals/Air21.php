<?php
namespace App\Globals;
use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use HttpRequest;

use App\Globals\Settings;
use App\Globals\Transaction;

/**
 * Air21 - all sending and tracking ship module
 *
 * @author Edward Guevarra
 */
class Air21
{
	/**
	 * [sendInfo send data to Air21 API for tracking]
	 * @param  [int] $transaction_list_id [order id]
	 * @return [array]                    ['status', 'status_message']
	 */
	public static function sendInfo($transaction_list_id)
	{
		$transaction	   = Transaction::get_data_transaction_list($transaction_list_id);
		$transaction_total = Transaction::get_transaction_item_total($transaction_list_id);
		$customer		   = Transaction::getCustomerInfoTransaction($transaction_list_id);
		$customer_address  = Transaction::getCustomerAddressTransaction($transaction_list_id);
		
		$return['status']		  = "error";
		$return['status_message'] = "Some error occurred. Please contact the administator.";
		
		if ($transaction && $customer) 
		{
			$pnm["cons_acct_num"]     = null; // Consignee/Recipient's Account Number (if there's any) char (17)
			$pnm["cons_name"]         = $customer->first_name . " " . $customer->middle_name . " " . $customer->last_name; // Consignee/Recipient's Name char (35)
			$pnm["ship_to"]           = "Air21"; // Consignee/Recipient's Company Name (if there's any) char (35)
			$pnm["ship_to_addr1"]     = $customer_address->customer_street ? $customer_address->customer_street : 'None'; // Shipper's House/Bldg/Street Number char (35)
			$pnm["ship_to_addr2"]     = $customer_address->customer_zipcode ? $customer_address->customer_zipcode : 'None'; // Shipper's Barangay/Locality char (35)
			$pnm["ship_to_addr3"]     = $customer_address->customer_city ? $customer_address->customer_city : 'None'; // Shipper's City/Municipality char (35)
			$pnm["ship_to_addr4"]     = $customer_address->customer_state ? $customer_address->customer_state : 'None'; // Shipper's Province char (35)
			$pnm["ship_to_zip"]       = "3014"; // Consignee/Recipient's ZIP Code. Follows PH postal code char (17)
			$pnm["ship_to_tel"]       = ""; // Consignee/Recipient's Landline Number char (35)
			$pnm["ship_to_email"]     = ""; // Consignee/Recipient's Email Address char (35)
			$pnm["ship_to_mobile"]    = ""; // Consignee/Recipient's Mobile Number char (17)
			$pnm["shp_val"]           = $transaction_total; // Shipment's Declared Value numeric (10)
			$pnm["shp_wt"]            = 0.11; // Shipment's Actual Weight (in kgs) numeric (6)
			$pnm["shp_dim"]           = 2.85; // Computed Value of (Length x Width x Height)/3500 numeric (6)
			$pnm["tp_acct_num"]       = null; // 3rd Party Account Number (if to be billed on a 3rd party account, leave NULL for Expresspay) 
			$pnm["svc_type"]          = "EXPDTD"; // Default to "EXPDTD"
			$pnm["pay_type"]          = "BILSHP"; // Default to "BILSHP"
			$pnm["contents"]          = "Cellphone"; // Actual Contents of the Shipment
			$pnm["batch_num"]         = ""; // NULL
			$pnm["acc_cour"]          = ""; // NULL
			$pnm["outlet_acct_num"]   = ""; // NULL
			$pnm["dropoff_loc"]       = ""; // NULL
			$pnm["pack_num"]          = 1; // Number of packages
			$pnm["cust_billgrp"]      = ""; // NULL
			$pnm["client_addr_class"] = "C"; // Default to C (for Commercial)
			$pnm["ship_to_add_class"] = "C"; // "R" if recipient's address is Residential, "C" if recipient's address is Commercial
			$pnm["collection_amount"] = 300; // Amount to be collected (if there's any, NULL if none)
		
			$packages["pkg_wt"]     = 0.11; // Actual Weight of the package (in kgs) numeric (5)
			$packages["pkg_type"]   = "DD00000004"; // Default to "DD00000001" (Sulight Small Pouch) char (17)
			$packages["pkg_length"] = "1"; // Actual Length of the package (in cm) numeric (5)
			$packages["pkg_width"]  = "1"; // Actual Width of the package (in cm) numeric (5)
			$packages["pkg_height"] = "1"; // Actual Height of the package (in cm) numeric (5)
		
			$reference_number["cref_num"] = $transaction->transaction_number; // Customer's own reference number char (35)
		
			$booking["client_name1"]   = "Juan dela Cruz"; // PICKUP LOCATION CONTACT PERSON char (35)
			$booking["client_name2"]   = "MyPhone"; // PICKUP LOCATION COMPANY NAME char (35)
			$booking["pup_addr1"]      = "4th Floor Cargohaus Bldg"; // PICKUP LOCATION ADDRESS 1 char (35)
			$booking["pup_addr2"]      = "Brgy Vitalez"; // PICKUP LOCATION ADDRESS 2 char (35)
			$booking["pup_addr3"]      = "Paranaque City"; // PICKUP LOCATION ADDRESS 3 char (35)
			$booking["pup_addr4"]      = "Metro Manila"; // PICKUP LOCATION ADDRESS 4 char (35)
			$booking["pup_zip_code"]   = "1709"; // PICKUP LOCATION ZIP CODE char (17)
			$booking["client_telfax"]  = ""; // Shipper's Landline Number char (35)
			$booking["client_contact"] = "Juan dela Cruz"; // Shipper's Contact Person char (35)
			$booking["rem_courier"]    = "landmark: near NAIA 2"; // NOTES TO COURIER char (100)
			$booking["sched_pup_date"] = date('Y-m-d h:i:s A', time() + 86400); // SCHEDULE PICKUP DATE datetime
			$booking["ready_time"]     = "14:00"; // PACKAGE/SHIPMENT READY TIME char (5)
			$booking["close_time"]     = "17:00"; // PICKUP LOCATION CLOSING TIME char (5)
		
			$json_pnm              = json_encode($pnm);
			$json_packages         = json_encode($packages);
			$json_reference_number = json_encode($reference_number);
			$json_booking          = json_encode($booking);
			
			$curl = curl_init();
		
			$post_fields = '{
							  "shipments": [
							    {
							      "pmn": ' . $json_pnm . ',
							      "packages": [' . $json_packages . '],
							      "reference_number": [' . $json_reference_number . '],
							      "booking": [' . $json_booking . ']
							    }
							  ]
							}';
		
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://210.14.17.243/api_test/pmn/myphone",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $post_fields,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/json",
			    "postman-token: 16e4b03d-c1aa-372d-411b-99595a97d32f"
			  ),
			));
		
			$response = curl_exec($curl);
			$err = curl_error($curl);
		
			curl_close($curl);
		
			if ($err) 
			{
				$return["status_message"] = $err;
			} 
			else 
			{
				if (isJson($response)) 
				{
					$result = json_decode($response);
					dd($result);
					if ($result->success) 
					{
						$return["status"]  = "success";
						$return["message"] = $result->message;
					}
				}
			}
		}
		
		return $return;
	}
}