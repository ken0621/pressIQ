<?php
namespace App\Globals;
use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use HttpRequest;
use Carbon\Carbon;

use App\Globals\Settings;
use App\Globals\Transaction;

use App\Models\Tbl_air21;
use App\Models\Tbl_transaction_list;

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
		$customer		   = null;
		$customer_address  = null;
		
		if ($transaction) 
		{
			$customer		   = Transaction::getCustomerInfoTransaction($transaction->transaction_id);
			$customer_address  = Transaction::getCustomerAddressTransaction($transaction->transaction_id);
		}
		
		$return['status']		  = "error";
		$return['status_message'] = "Some error occurred. Please contact the administator.";
		
		if ($transaction && $customer && $customer_address) 
		{
			$customer_zipcode  = Air21::getZipcode($customer_address->customer_street) ? Air21::getZipcode($customer_address->customer_street) : '3014';

			$pnm["cons_acct_num"]     = null; // Consignee/Recipient's Account Number (if there's any) char (17)
			$pnm["cons_name"]         = $customer->first_name . " " . $customer->middle_name . " " . $customer->last_name; // Consignee/Recipient's Name char (35)
			$pnm["ship_to"]           = "Air21"; // Consignee/Recipient's Company Name (if there's any) char (35)
			$pnm["ship_to_addr1"]     = $customer_address->customer_street ? $customer_address->customer_street : 'None'; // Shipper's House/Bldg/Street Number char (35)
			$pnm["ship_to_addr2"]     = $customer_address->customer_zipcode ? $customer_address->customer_zipcode : 'None'; // Shipper's Barangay/Locality char (35)
			$pnm["ship_to_addr3"]     = $customer_address->customer_city ? $customer_address->customer_city : 'None'; // Shipper's City/Municipality char (35)
			$pnm["ship_to_addr4"]     = $customer_address->customer_state ? $customer_address->customer_state : 'None'; // Shipper's Province char (35)
			$pnm["ship_to_zip"]       = $customer_zipcode; // Consignee/Recipient's ZIP Code. Follows PH postal code char (17)
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
		
			$booking["client_name1"]   = $customer->first_name . " " . $customer->middle_name . " " . $customer->last_name; // PICKUP LOCATION CONTACT PERSON char (35)
			$booking["client_name2"]   = "MyPhone"; // PICKUP LOCATION COMPANY NAME char (35)
			$booking["pup_addr1"]      = $customer_address->customer_street ? $customer_address->customer_street : 'None'; // PICKUP LOCATION ADDRESS 1 char (35)
			$booking["pup_addr2"]      = $customer_address->customer_zipcode ? $customer_address->customer_zipcode : 'None'; // PICKUP LOCATION ADDRESS 2 char (35)
			$booking["pup_addr3"]      = $customer_address->customer_city ? $customer_address->customer_city : 'None'; // PICKUP LOCATION ADDRESS 3 char (35)
			$booking["pup_addr4"]      = $customer_address->customer_state ? $customer_address->customer_state : 'None'; // PICKUP LOCATION ADDRESS 4 char (35)
			$booking["pup_zip_code"]   = $customer_zipcode; // PICKUP LOCATION ZIP CODE char (17)
			$booking["client_telfax"]  = ""; // Shipper's Landline Number char (35)
			$booking["client_contact"] = "MyPhone"; // Shipper's Contact Person char (35)
			$booking["rem_courier"]    = ""; // NOTES TO COURIER char (100)
			$booking["sched_pup_date"] = date('Y-m-d h:i:s A', time() + 172800); // SCHEDULE PICKUP DATE datetime
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
					$update = Air21::updateResponse($transaction_list_id, $result);

					if ($result->success) 
					{
						$return["status"]  = "success";
						$return["status_message"] = $result->message;
					}
				}
			}
		}
		
		return $return;
	}
	/**
	 * [updateResponse update order via air21 response]
	 * @param  [integer] $transaction_list_id [order id]
	 * @param  [array] $response              [air21 response]
	 * @return [array]                    	  ['status', 'status_message']
	 */
	public static function updateResponse($transaction_list_id, $response)
	{
		$insert_air21["transaction_list_id"] = $transaction_list_id;
		$insert_air21["response"]            = serialize($response);
		$insert_air21["success"]             = $response->success ? 1 : 0;
		$insert_air21["message"]             = isset($response->message) ? $response->message : '';
		$insert_air21["tracking_num"]        = isset($response->api_response[0]->cref[0]->track_num) ? $response->api_response[0]->cref[0]->track_num : '';
		$insert_air21["shp_date"]            = isset($response->api_response[0]->pmn->shp_date) ? $response->api_response[0]->pmn->shp_date : '';
		$insert_air21["response_date"]       = Carbon::now();
		
		$result = Tbl_air21::insert($insert_air21);

		if ($result && isset($response->message) && isset($response->api_response[0]->cref[0]->track_num) && isset($response->api_response[0]->pmn->shp_date)) 
		{
			$return['status']		  = "success";
			$return['status_message'] = "The tracking number has been updated.";
		}
		else
		{
			$return['status']		  = "error";
			$return['status_message'] = isset($response->message) ? $response->message : "Some error occurred. Please contact the administator.";
		}

		return $return;
	}

	/**
	*
	* Author: CodexWorld
	* Author URI: http://www.codexworld.com
	* Function Name: getZipcode()
	* $address => Full address.
	*
	**/
	public static function getZipcode($address)
	{
		try 
		{
			if(!empty($address))
		    {
		        //Formatted address
		        $formattedAddr = str_replace(' ','+',$address);
		        //Send request and receive json data by address
		        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 
		        $output1 = json_decode($geocodeFromAddr);
		        //Get latitude and longitute from json data
		        $latitude  = $output1->results[0]->geometry->location->lat; 
		        $longitude = $output1->results[0]->geometry->location->lng;
		        //Send request and receive json data by latitude longitute
		        $geocodeFromLatlon = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true_or_false');
		        $output2 = json_decode($geocodeFromLatlon);
		        if(!empty($output2))
		        {
		            $addressComponents = $output2->results[0]->address_components;
		            foreach($addressComponents as $addrComp)
		            {
		                if($addrComp->types[0] == 'postal_code')
		                {
		                    //Return the zipcode
		                    return $addrComp->long_name;
		                }
		            }
		            return false;
		        }
		        else
		        {
		            return false;
		        }
		    }
		    else
		    {
		        return false;   
		    }
		} 
		catch (\Exception $e) 
		{
			return false;
		}
	}
}