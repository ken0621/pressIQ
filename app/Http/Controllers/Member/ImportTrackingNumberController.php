<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Models\Tbl_user;
use App\Models\Tbl_vendor;
use App\Models\Tbl_vendor_address;
use App\Models\Tbl_vendor_other_info;
use App\Models\Tbl_country;
use App\Models\Tbl_payment_method;
use App\Models\Tbl_term;
use App\Models\Tbl_delivery_method;
use App\Models\Tbl_vendor_item;

use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Utilities;
use App\Globals\Item;
use Carbon\Carbon;
use Request;
use Response;
use Image;
use Validator;
use Redirect;
use File;
use Crypt;
use URL;
use Session;
use Excel;
use DB;

class ImportTrackingNumberController extends Member
{
    public function hasAccess($page_code, $acces)
    {
        $access = Utilities::checkAccess($page_code, $acces);
        if($access == 1) return true;
        else return false;
    }
    
	public function getIndex()
	{
	    if ($this->hasAccess('import-tracking-number', 'access_page')) 
	    {
	        $data = [];
	        
	        return view("member.import-tracking.index", $data);
	    }
	    else
	    {
	        return $this->show_no_access();
	    }
	}
	
	public function getItemTemplate()
	{
		Excel::create("ItemTemplate", function($excel)
		{
			// Set the title
		    $excel->setTitle('Digimahouse');

		    // Chain the setters
		    $excel->setCreator('DigimaWebSolutions')
		          ->setCompany('DigimaWebSolutions');

		    $excel->sheet('Template', function($sheet) {
		    	$header = [
		    				'Order Number',
		    				'Tracking Number'
		    				];
		    	$sheet->freezeFirstRow();
		        $sheet->row(1, $header);

		    });


		})->download('csv');
	}
	
	public function postItemReadFile()
	{
		Session::forget("import_item_error");

		$value     = Request::input('value');
		$input     = Request::input('input');

		$ctr 	   		= Request::input('ctr');
		$data_length 	= Request::input('data_length');
		$error_data 	= Request::input('error_data');

		if($ctr != $data_length)
		{
			/* Variables */
			$order_number = $value["Order Number"];
			$tracking_number = $value["Tracking Number"];
		
			/* Validation */
			$order = DB::table("tbl_ec_order")->where("ec_order_id", $order_number)->first();

			if($order)
			{
				/* Update */
				$update["tracking_no"] = $tracking_number;
				DB::table("tbl_ec_order")->where("ec_order_id", $order_number)->update($update);
				
				$json["status"]		= "success";
				$json["message"]	= "Success";
			}
			else
			{
				$json["status"]		= "error";
				$json["message"]	= "Order doesn't exist.";
			}

			$status_color 		= $json["status"] == 'success' ? 'green' : 'red';
			$json["tr_data"]	= "<tr>";
			$json["tr_data"]   .= "<td>".$order_number."</td>";
			$json["tr_data"]   .= "<td>".$tracking_number."</td>";
			$json["tr_data"]   .= "</tr>";

			$json["value_data"] = $value;
			$length 			= sizeOf($json["value_data"]);

			foreach($json["value_data"] as $key=>$value)
			{
				$json["value_data"]['Error Description'] = $json["message"];
			}
		}
		else /* DETERMINE IF LAST IN CSV */
		{
			Session::put("import_item_error", $error_data);
			$json["status"] = "end";
		}

        return json_encode($json);
	}

	public function getItemExportError()
	{
		$_value = Session::get("import_item_error");

		if($_value)
		{
			Excel::create("ItemImportError", function($excel) use($_value)
			{
				// Set the title
			    $excel->setTitle('Digimahouse');

			    // Chain the setters
			    $excel->setCreator('DigimaWebSolutions')
			          ->setCompany('DigimaWebSolutions');

			    $excel->sheet('Template', function($sheet) use($_value) {
			    	$header = [
			    				'Type',
			    				'Name',
			    				'Sku',
			    				'UM',
			    				'Category',
			    				'Sales Information',
			    				'Sales Price',
			    				'Income Account',
			    				'Sale to Customer',
			    				'Purchase From Supplier',
			    				'Purchasing Information',
			    				'Purchase Cost',
			    				'Barcode',
			    				'Qty on Hand',
			    				'Reorder Point',
			    				'As of Date',
			    				'Asset Account',
			    				'Packing Size',
			    				'Manufacturer',
			    				'Error_Description'
			    				];
			    	$sheet->freezeFirstRow();
			        $sheet->row(1, $header);
			        foreach($_value as $key=>$value)
			        {
			        	$sheet->row($key+2, $value);
			        }

			    });


			})->download('csv');
		}
		else
		{
			return Redirect::back();
		}
	}
}