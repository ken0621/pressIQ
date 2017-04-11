<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * Accounting Module - all accounting related module
 *
 * @author Bryan Kier Aradanas
 */
class Accounting
{

	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	/**
	 * Getting all the list of accounts including sub-accounts
	 *
	 * @param string  	$filter 	(all, active, inactive)
	 * @param integer  	$parent_id  Id of the Chart of Accoutn where will it start
	 * @param array  	$type      	Filter of type of Chart of Account (eg: Accounts Payable)
	 * @param boolean  	$balance    If it will show total balance of each account (true, false)
	 */
	public static function getAllAccount($filter = 'all', $parent_id = null, $type = null, $balance = false)
	{
		$shop = Accounting::getShopId();

		if($parent_id)
		{
			$sublevel 	= Tbl_chart_of_account::where("account_parent_id", $parent_id)->pluck("account_sublevel");
		}
		else
		{
			$sublevel 	= 0;
			$parent_id 	= null;
		}

		$result = Accounting::checkAccount($shop, $parent_id, $sublevel, $filter, $type);
		//dd($result);
		return $result;
	}

	public static function checkAccount($shop, $parent_id, $sublevel, $filter, $type)
	{
		$query = Tbl_chart_of_account::accountInfo($shop)->where("account_parent_id", $parent_id)->where("account_sublevel", $sublevel);

		switch($filter)
		{
			case 'active':
				$query->where("archived", 0);
				break;
			case 'inactive':
				$query->where("archived", 1);
				break;
		}

		if($type != null) $query->whereIn("chart_type_name", $type);
		
		$query = $query->get();

		foreach($query as $key => $item)
		{
			$result[$key]["account_id"] 			= $item->account_id;
			$result[$key]["account_number"]			= $item->account_number;
			$result[$key]["account_name"]			= $item->account_name;
			$result[$key]["account_type"] 			= $item->chart_type_name;
			$result[$key]["account_description"] 	= $item->account_description;
			$result[$key]["account_sublevel"] 		= $item->account_sublevel;
			$sub_query = Tbl_chart_of_account::where("account_parent_id", $item->account_id)->first();
			
			if($sub_query)
			{
				$result[$key]["sub_account"] = Accounting::checkAccount($shop, $item->account_id, $sublevel + 1, $filter, $type);
			}
			else
			{
				$result[$key]["sub_account"] = null;
			}
		}

		if($query->count() > 0) return $result;
		else 					return 'No Result Found!';
	}

	/**
	 * Getting all the list of accounts including sub-accounts
	 *
	 * @param string  	$account_id 	account id of specific account
	 */
	public static function getAccount($account_id)
	{
		$shop = Accounting::getShopId();

		$result = Tbl_chart_of_account::accountInfo($shop)->where("account_id",$account_id)->first(['account_id', 'account_name', 'chart_type_name', 'account_description'])->toArray();
		// dd($result);
		return json_encode($result);
	}

	public static function getItemAccount($item_id, $balance = false)
	{
		$asset 		= Tbl_item::where("item_id", $item_id)->accountAsset()
								->first(['account_id','account_name','chart_type_name','account_description'])->toArray();
		$income 	= Tbl_item::where("item_id", $item_id)->accountIncome()
								->first(['account_id','account_name','chart_type_name','account_description'])->toArray();
		$expense 	= Tbl_item::where("item_id", $item_id)->accountExpense()
								->first(['account_id','account_name','chart_type_name','account_description'])->toArray();
		$result["income"] 				= $income;
		$result["asset"] 				= $asset;
		$result["cost_of_good_sold"] 	= $expense;

		dd($result);
	}

	public static function insertJournalEntry()
	{
		$shop_id = Accounting::getShopId();

		$journal_entry['je_shop_id'] 			= $shop_id;
		$journal_entry['je_reference_module'] 	= $reference_module;
		$journal_entry['je_reference_id'] 		= $reference_id;
		$journal_entry['je_entry_date'] 		= carbon::now();
		$journal_entry['je_remarks']			= $remarks;

		$rules['je_reference_module']			= 'required';
		$rules['je_reference_id']				= 'required';

		$validator = Validator::make($journal_entry, $rules);

		if (!$validator->passes())
		{
			$json['status'] 		= 'error';
			$json['status_message']	= $validator->errors()->all();
			return json_encode($json);
		}

		$je_id = Tbl_journal_entry::insertGetId($journal_entry);

		foreach($entry_data as $key=>$line)
		{
			$journal_line['jline_je_id']		= $je_id;
			$journal_line['jline_item_id'] 		= $line["item_id"];
			$journal_line['jline_account_id'] 	= $line["account_id"];
			$journal_line['jline_type'] 		= $line["entry_type"];
			$journal_line['jline_amount'] 		= $line["entry_amount"];
			$journal_line['jline_description'] 	= $line["entry_description"];

			Tbl_journal_entry_line::insert($journal_line);
		}

		return $je_id;
		// json['status'] = 'success';
		// return json_encode($json);
	}

	/**
	 * Create a journal entry for the transaction 
	 *
	 * @param string  	$reference_module 	Type of transaction
	 * @param integer  	$reference_id  		Id of the transaction
	 * @param array  	$entry_data 		Entry data for the journal Entry
	 * @param array  	$entry_date      	
	 * @param boolean  	$remarks   			
	 */
	public static function postJournalEntry($entry, $entry_data, $remarks = '')
	{
		// $entry["reference_module"]	= "invoice";
		// $entry["reference_id"]		= "invoice";

		// $entry["total"]		= 180;
		// $entry["vatable"]	= 0;
		// $entry["discount"]	= 20;
		// $entry["ewt"]		= 0;

		// $entry_data[0]['item_id'] 		= 15;
		// $entry_data[0]['entry_qty'] 	= 5;
		// $entry_data[0]['vatable']		= 0;
		// $entry_data[0]['discount']		= 0;
		// $entry_data[0]['entry_amount'] 	= 200;

		$account_receivable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-receivable")->pluck("account_id");
		$account_payable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-payable")->pluck("account_id");

		$account_asset 		= Tbl_item::where("item_id", 39)->pluck("item_asset_account_id");   //Inventory 
		$account_income 	= Tbl_item::where("item_id", 39)->pluck("item_income_account_id");  //Sales
		$account_expense 	= Tbl_item::where("item_id", 39)->pluck("item_expense_account_id"); //Cost of Good Sold


		/* INSERT JOURNAL ENTRY */
		$journal_entry['je_shop_id'] 			= Accounting::getShopId();
		$journal_entry['je_reference_module'] 	= $entry["reference_module"];
		$journal_entry['je_reference_id'] 		= $entry["reference_id"];
		$journal_entry['je_entry_date'] 		= carbon::now();
		$journal_entry['je_remarks']			= $remarks;

		$line_data["je_id"] 	= Tbl_journal_entry::insertGetId($journal_entry);
		$line_data["item_id"]	= '';

		/* RECIVABLE OR PAYABLE */
		if(Accounting::checkReceivable($entry["reference_module"]))
		{
			$line_data["entry_amount"]	= $entry["total"];
			$line_data["entry_type"] 	= "Debit";
			$line_data["account_id"] 	= $account_receivable;
			Accounting::insertJournalLine($line_data);

			/* DISCOUNT AS WHOLE */
			if($entry["discount"] > 0)
			{
				$line_data["entry_amount"]	= $entry["discount"];
				$line_data["entry_type"] 	= "Debit";
				$line_data["account_id"] 	= Accounting::getDiscountSale();
				Accounting::insertJournalLine($line_data);
			}

			/* VATABLE AS WHOLE */
			if($entry["vatable"] > 0)
			{
				$line_data["entry_amount"]	= $entry["vatable"];
				$line_data["entry_type"] 	= "Credit";
				$line_data["account_id"] 	= Accounting::getOutputVatPayable();
				Accounting::insertJournalLine($line_data);
			}

			/* EWT AS WHOLE */
			if($entry["ewt"] > 0)
			{
				$line_data["entry_amount"]	= $entry["ewt"];
				$line_data["entry_type"] 	= "Debit";
				$line_data["account_id"] 	= Accounting::getWitholdingTax();
				Accounting::insertJournalLine($line_data);
			}
		}
		else
		{
			$line_data["entry_amount"]	= $entry["total"];
			$line_data["entry_type"] 	= "Credit";
			$line_data["account_id"] 	= $account_payable;
			Accounting::insertJournalLine($line_data);

			/* DISCOUNT AS WHOLE */
			if($entry["discount"] > 0)
			{
				$line_data["entry_amount"]	= $entry["discount"];
				$line_data["entry_type"] 	= "Credit";
				$line_data["account_id"] 	= Accounting::getDiscountPurchase();
				Accounting::insertJournalLine($line_data);
			}

			/* VATABLE AS WHOLE */
			if($entry["vatable"] > 0)
			{
				$line_data["entry_amount"]	= $entry["vatable"];
				$line_data["entry_type"] 	= "Debit";
				$line_data["account_id"] 	= Accounting::getOutputVatPayable();
				Accounting::insertJournalLine($line_data);
			}

			/* EWT AS WHOLE */
			if($entry["ewt"] > 0)
			{
				$line_data["entry_amount"]	= $entry["ewt"];
				$line_data["entry_type"] 	= "Credit";
				$line_data["account_id"] 	= Accounting::getWitholdingTax();
				Accounting::insertJournalLine($line_data);
			}
		}

		foreach($entry_data as $entry_line)
		{
			$item = Tbl_item::where("item_id", $entry_line["item_id"])->first();

			$line_data["item_id"] = $entry_line["item_id"];

			if($entry["reference_module"] == "invoice")
			{
				/* INCOME ACCOUNT */
				$line_data["entry_amount"]	= $entry_line["entry_amount"];
				$line_data["entry_type"] 	= "Credit";
				$line_data["account_id"] 	= $account_income;
				Accounting::insertJournalLine($line_data);

				if($item->item_type_id == 1)
				{
					/* EXPENSE ACCOUNT */
					$line_data["entry_amount"]	= $item->item_cost;
					$line_data["entry_type"] 	= "Debit";
					$line_data["account_id"] 	= $account_expense;
					Accounting::insertJournalLine($line_data);

					/* ASSET ACCOUNT */
					$line_data["entry_amount"]	= $item->item_cost;
					$line_data["entry_type"] 	= "Credit";
					$line_data["account_id"] 	= $account_asset;
					Accounting::insertJournalLine($line_data);
				}
			}
		}

		return $line_data["je_id"];
		// $_first 	= Tbl_item::accountAsset()->where("item_id", 39)->select("item_id","item_asset_account_id as account_id", "account_name", "chart_type_name", "normal_balance")->where("item_asset_account_id","<>", "NULL");
		// $_second 	= Tbl_item::accountIncome()->where("item_id", 39)->select("item_id","item_income_account_id as account_id", "account_name", "chart_type_name", "normal_balance")->where("item_income_account_id","<>", "NULL");
		// $_third 	= Tbl_item::accountExpense()->where("item_id", 39)->select("item_id","item_expense_account_id  as account_id", "account_name", "chart_type_name", "normal_balance")->where("item_expense_account_id","<>", "NULL");	

		// dd($_second->union($_first)->union($_third)->get()->toArray());
	}

	public static function insertJournalLine($line)
	{
		$journal_line['jline_je_id']		= $line["je_id"];
		$journal_line['jline_item_id'] 		= $line["item_id"];
		$journal_line['jline_account_id'] 	= $line["account_id"];
		$journal_line['jline_type'] 		= $line["entry_type"];
		$journal_line['jline_amount'] 		= $line["entry_amount"];
		$journal_line['jline_description'] 	= isset($line["entry_description"]) ? $line["entry_description"] : '';

		Tbl_journal_entry_line::insert($journal_line);
	}

	public static function checkReceivable($type)
	{
		if($type == "invoice")
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check what table reference
	 *
	 * @param 	string  	$type 		Type of a transaction
	 * @return 	array[2] 	$table_name | id_name
	 */
	public static function checkReferenceId($type)
	{
		switch($type)
		{
			case 'invoice':
				$data["table_txn_reference"] 	= 'Tbl_customer_invoice';
				$data["txn_id"]					= 'je_id';			
				$data["table_name_reference"]	= 'Tbl_customer';
				$data["name_id"]				= 'customer_id';
				break;

			case 'purchase_order':
				$data["table_txn_reference"] 	= 'Tbl_purchase_order';
				$data["txn_id"]					= 'je_id';			
				$data["table_name_reference"]	= 'Tbl_vendor';
				$data["name_id"]				= 'vendor_id';
				break;
			case 'receive-payment':
				break;
			default:
				$data = null;
		}

		return $data;
	}

	/**
	 * Get Chart of Account - Output Vat Payable for Vatable transaction
	 *
	 * @return 	int 	ID
	 */
	public static function getOutputVatPayable()
	{
		$exist_account = Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_code", "tax-output-vat-payable")->first();
        if(!$exist_account)
        {
            $insert["account_shop_id"]          = $shop_id;
            $insert["account_type_id"]          = 9;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Output Vat Payable";
            $insert["account_description"]      = "";
            $insert["account_protected"]        = 1;
            $insert["account_code"]             = "tax-output-vat-payable";
            
            return Tbl_chart_of_account::insertGetId($insert);
        }

        return $exist_account->account_id;
	}

	/**
	 * Get Chart of Account - Creditable witholding tax for Witholding transaction
	 *
	 * @return 	int 	ID
	 */
	public static function getWitholdingTax()
	{
		$exist_account = Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_code", "tax-credit-tax-1")->first();
        if(!$exist_account)
        {
            $insert["account_shop_id"]          = Accounting::getShopId();
            $insert["account_type_id"]          = 3;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Creditable Withholding Tax - 1%";
            $insert["account_description"]      = "";
            $insert["account_protected"]        = 1;
            $insert["account_code"]             = "tax-credit-tax-1";
            
            return Tbl_chart_of_account::insertGetId($insert);
        }

        return $exist_account->account_id;
	}

	/**
	 * Get Chart of Account - Discount for Discounted Sale transaction
	 *
	 * @return 	int 	ID
	 */
	public static function getDiscountSale()
	{
		$exist_account = Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_code", "discount-sale")->first();
        if(!$exist_account)
        {
            $insert["account_shop_id"]          = Accounting::getShopId();
            $insert["account_type_id"]          = 4;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Discount";
            $insert["account_description"]      = "";
            $insert["account_protected"]        = 1;
            $insert["account_code"]             = "discount-sale";
            
            return Tbl_chart_of_account::insertGetId($insert);
        }

        return $exist_account->account_id;
	}

	/**
	 * Get Chart of Account - Discount for Discounted Purchase transaction
	 *
	 * @return 	int 	ID
	 */
	public static function getDiscountPurchase()
	{
		$exist_account = Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_code", "discount-purchase")->first();
        if(!$exist_account)
        {
            $insert["account_shop_id"]          = Accounting::getShopId();
            $insert["account_type_id"]          = 4;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Discount";
            $insert["account_description"]      = "";
            $insert["account_protected"]        = 1;
            $insert["account_code"]             = "discount-puchase";
            
            return Tbl_chart_of_account::insertGetId($insert);
        }

        return $exist_account->account_id;
	}

	/* REFERENCE OF THE NAMING OF THE CHART OF ACCOUNT TABLE */

	// Output Vat Payable 						= tax-output-vat-payable
	// Creditable Withholding Tax - 1%			= tax-credit-tax-1
	// Discount									= discount-sale
	// Discount									= discount-purchase

		public static function getJournalById($reference_module, $reference_id)
	{
		// $journal = Tbl_journal_entry::where("je_reference_id", $reference_id)->where("je_reference_module", $reference_module)->first();

		// $result["status"] 			= 'success';
		// $result["status_message"]	= null;

		// if(count($journal) > 0) 
		// {
		// 	$journal_line = Tbl_journal_entry_line::account()->where("jline_je_id", $journal->je_id)->get(['account_id','jline_type', 'jline_amount','jline_description'])->toArray();

		//   	$result["entry_data"] = $journal_line;
		// }
		// else 
		// {
		// 	$result["entry_data"] = null;
		// }
		$shop = Accounting::getShopId();

		$_journal_entry = Tbl_journal_entry::selectRaw("je_id as je_id, je_entry_date as entry_date, je_remarks as remarks")
											->where("je_shop_id", $shop)->where("je_reference_id", $reference_id)->where("je_reference_module", $reference_module)->first();

        if(count($_journal_entry) > 0)
		{
	        $result['tbl_journal_entry'] = [];

	        $result 					= $_journal_entry->toArray();
	        $result['status'] 			= 'success';
	        $result['status_message'] 	= '';
	        $_journal_line = Tbl_journal_entry_line::selectedLimit()->where("jline_je_id", $_journal_entry['je_id'])->get()->toArray();
	        $result['entry_data'] = $_journal_line;
    	}

		dd($result);
		if(count($_journal_entry) > 0)	    return $result;
		else 								return 'No Result Found!';
	}

	public static function getJournalByDate($reference_module, $start_date, $end_date)
	{
		$shop = Accounting::getShopId();

		$_journal_entry = Tbl_journal_entry::selectRaw("je_id as je_id, je_reference_module as reference_module, je_reference_id as reference_id, je_entry_date as entry_date, je_remarks as remarks")
											->where("je_shop_id", $shop)->where("je_reference_module", $reference_module)
											->where("je_entry_date",">=", $start_date)->where("je_entry_date","<=", $end_date)
											->first();

		if(count($_journal_entry) > 0)
		{
	        $result['tbl_journal_entry'] = [];

	        $result 					= $_journal_entry->toArray();
	        $result['status'] 			= 'success';
	        $result['status_message'] 	= '';
	        $_journal_line = Tbl_journal_entry_line::selectedLimit()->where("jline_je_id", $_journal_entry['je_id'])->get()->toArray();
	        $result['entry_data'] = $_journal_line;
    	}

		dd($result);
		if(count($_journal_entry) > 0)	    return $result;
		else 								return 'No Result Found!';
	}

	public static function getJounalAll()
	{
		$shop = Accounting::getShopId();

		$_journal_entry = Tbl_journal_entry::where("je_shop_id", $shop)->get()->toArray();

        $data['tbl_journal_entry'] = [];

        foreach($_journal_entry as $key => $journal)
        {
            $data['tbl_journal_entry'][$key] = $journal;
            $_journal_line = Tbl_journal_entry_line::account()->item()->where("jline_je_id", $journal['je_id'])->get();
            $data['tbl_journal_entry'][$key]['debit'] 	= $_journal_line->where("jline_type", 'debit')->sum('jline_amount');
            $data['tbl_journal_entry'][$key]['credit'] 	= $_journal_line->where("jline_type", 'credit')->sum('jline_amount');
            $data['tbl_journal_entry'][$key]['journal_line'] = $_journal_line->toArray();
        }
        // dd($data['tbl_journal_entry']);
        return $data['tbl_journal_entry'];
	}
}