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
 * Accounting Module - all accounting related module -accounts
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
	 * @param boolean  	$balance    If it will show total balance of each account (true, false) (CURRENTLY NOT WORKING)
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

	/**
	 * Create a journal entry for the transaction 
	 *
	 * @param array  	$entry 			$entry["reference_module"] , $entry["reference_id"] , $entry["name_id"], $entry["total"] , 
	 *									$entry["vatable"] , $entry["discount"] , $entry["ewt"]
	 * @param array  	$entry_data     $entry_data[0]['item_id'], $entry_data[0]['vatable']
	 *									$entry_data[0]['discount'] , $entry_data[0]['entry_amount']
	 * @param boolean  	$remarks   		Description of the journal entry	
	 */
	public static function postJournalEntry($entry, $entry_data, $remarks = '')
	{
		/* GETTING THE DEFAULT ACCOUNTS RECEIVABLE AND ACCOUNTS PAYABLE */
		$account_receivable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-receivable")->pluck("account_id");
		$account_payable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-payable")->pluck("account_id");

		/* FOR OLD DATABASE - CHECKING IF THERE IS ALREADY AN ACCOUNT CODE*/
		if(!$account_receivable)
		{
			Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_name", "Accounts Receivable")->update(['account_code'=>"accounting-receivable"]);
			$account_receivable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-receivable")->pluck("account_id");
		}
		if(!$account_payable)
		{
			Tbl_chart_of_account::where("account_shop_id", Accounting::getShopId())->where("account_name", "Accounts Payable")->update(['account_code'=>"accounting-payable"]);
			$account_payable	= Tbl_chart_of_account::accountInfo(Accounting::getShopId())->where("account_code","accounting-payable")->pluck("account_id");
		}
		/* END */

		/* INSERT JOURNAL ENTRY */
		$journal_entry['je_shop_id'] 			= Accounting::getShopId();
		$journal_entry['je_reference_module'] 	= $entry["reference_module"];
		$journal_entry['je_reference_id'] 		= $entry["reference_id"];
		$journal_entry['je_entry_date'] 		= carbon::now();
		$journal_entry['je_remarks']			= $remarks;

		/* CHECK IF THE TRANSACTION JOURNAL IS ALREADY EXIST - USE IF NEW OR UPDATE TRANSACTION */
		$exist_journal = Tbl_journal_entry::where("je_reference_module", $journal_entry['je_reference_module'])->where("je_reference_id", $journal_entry['je_reference_id'])->first();

		if(!$exist_journal)
		{
			$line_data["je_id"] 	= Tbl_journal_entry::insertGetId($journal_entry);
		}
		else
		{
			unset($journal_entry['je_entry_date']);
			Tbl_journal_entry_line::where("jline_je_id", $exist_journal->je_id)->delete();
			Tbl_journal_entry::where("je_id", $exist_journal->je_id)->update($journal_entry);
			$line_data["je_id"] = $exist_journal->je_id;
		}

		$line_data["item_id"]				= '';
		$line_data["jline_name_reference"] 	= Accounting::checkTransaction($entry["reference_module"])['name'];
		$line_data["jline_name_id"]			= $entry["name_id"];

		/* RECIVABLE OR PAYABLE */
		if(Accounting::checkTransaction($entry["reference_module"])['is_receivable'])
		{
			$journalType = 	Accounting::checkTransaction($entry["reference_module"])['journal'];	 
			$line_data["entry_amount"]	= $entry["total"];
			$line_data["entry_type"] 	= Accounting::$journalType($account_receivable);
			$line_data["account_id"] 	= $account_receivable;
			Accounting::insertJournalLine($line_data);

			/* DISCOUNT AS WHOLE */
			if(isset($entry["discount"]))
			{
			if($entry["discount"] > 0)
			{
				$line_data["entry_amount"]	= $entry["discount"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getDiscountSale());
				$line_data["account_id"] 	= Accounting::getDiscountSale();
				Accounting::insertJournalLine($line_data);
			}
			}

			/* VATABLE AS WHOLE */
			if(isset($entry["vatable"]))
			{
			if($entry["vatable"] > 0)
			{
				$line_data["entry_amount"]	= $entry["vatable"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getOutputVatPayable());
				$line_data["account_id"] 	= Accounting::getOutputVatPayable();
				Accounting::insertJournalLine($line_data);
			}
			}

			/* EWT AS WHOLE */
			if(isset($entry["ewt"]))
			{
			if($entry["ewt"] > 0)
			{
				$line_data["entry_amount"]	= $entry["ewt"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getWitholdingTax());
				$line_data["account_id"] 	= Accounting::getWitholdingTax();
				Accounting::insertJournalLine($line_data);
			}
			}
		}
		else
		{
			$journalType = 	Accounting::checkTransaction($entry["reference_module"])['journal'];
			$line_data["entry_amount"]	= $entry["total"];
			$line_data["entry_type"] 	= Accounting::$journalType($account_payable);
			$line_data["account_id"] 	= $account_payable;
			Accounting::insertJournalLine($line_data);

			/* DISCOUNT AS WHOLE */
			if(isset($entry["discount"]))
			{
			if($entry["discount"] > 0)
			{
				$line_data["entry_amount"]	= $entry["discount"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getDiscountPurchase());
				$line_data["account_id"] 	= Accounting::getDiscountPurchase();
				Accounting::insertJournalLine($line_data);
			}
			}

			/* VATABLE AS WHOLE */
			if(isset($entry["vatable"]))
			{
			if($entry["vatable"] > 0)
			{
				$line_data["entry_amount"]	= $entry["vatable"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getOutputVatPayable());
				$line_data["account_id"] 	= Accounting::getOutputVatPayable();
				Accounting::insertJournalLine($line_data);
			}
			}

			/* EWT AS WHOLE */
			if(isset($entry["ewt"]))
			{
			if($entry["ewt"] > 0)
			{
				$line_data["entry_amount"]	= $entry["ewt"];
				$line_data["entry_type"] 	= Accounting::$journalType(Accounting::getWitholdingTax());
				$line_data["account_id"] 	= Accounting::getWitholdingTax();
				Accounting::insertJournalLine($line_data);
			}
			}
		}

		foreach($entry_data as $entry_line)
		{
			/* IF ITEM ID OR ACCOUNT ID */
			if(isset($entry_line["item_id"]))
			{
				$item = Tbl_item::where("item_id", $entry_line["item_id"])->first();
				$line_data["item_id"] = $entry_line["item_id"];

				/* GETTING CHART OF ACCOUNTS THAT TAGGED ON THE ITEM */
				$account_asset 		= Tbl_item::where("item_id", $entry_line["item_id"])->pluck("item_asset_account_id");   //Inventory 
				$account_income 	= Tbl_item::where("item_id", $entry_line["item_id"])->pluck("item_income_account_id");  //Sales
				$account_expense 	= Tbl_item::where("item_id", $entry_line["item_id"])->pluck("item_expense_account_id"); //Cost of Good Sold
			}
			elseif(isset($entry_line["account_id"]))
			{
				$account = Tbl_chart_of_account::type()->where("account_id", $entry_line["account_id"])->first();
			}


			switch($entry["reference_module"])
			{
				case "estimate":
					break;
				case "sales-order":
					break;
				case "invoice":
					/* INCOME ACCOUNT */
					$line_data["entry_amount"]	= $entry_line["entry_amount"];
					$line_data["entry_type"] 	= Accounting::normalBalance($account_income);
					$line_data["account_id"] 	= $account_income;
					Accounting::insertJournalLine($line_data);

					if($item->item_type_id == 1)
					{
						/* EXPENSE ACCOUNT */
						$line_data["entry_amount"]	= $item->item_cost;
						$line_data["entry_type"] 	= Accounting::normalBalance($account_expense);
						$line_data["account_id"] 	= $account_expense;
						Accounting::insertJournalLine($line_data);

						/* ASSET ACCOUNT */
						$line_data["entry_amount"]	= $item->item_cost;
						$line_data["entry_type"] 	= Accounting::contraAccount($account_asset);
						$line_data["account_id"] 	= $account_asset;
						Accounting::insertJournalLine($line_data);
					}
					break;
				case "sales-receipt":
					break;
				case "receive-payment":
					/* CASH ACCOUNT - BANK */
					$line_data["entry_amount"]	= $entry_line["entry_amount"];
					$line_data["entry_type"] 	= Accounting::normalBalance($account->account_id);
					$line_data["account_id"] 	= $account->account_id;
					Accounting::insertJournalLine($line_data);
					break;
				case "purchase-order":
					break;
				case "bill":
					break;
				case "bills-payment":
					break;
				case "credit-memo":
					break;
				case "debit-memo":
					break;
				// SO ON
			}
		}

		return $line_data["je_id"];
	}

	/**
	 * Create a manual journal entry for the transaction type "manual"
	 *
	 * @param array  	$entry 			$entry['entry_date'], $entry['je_id'] (NULL or not null)
	 * @param array  	$entry_data     $entry_data[0]['account_id'], $entry_data[0]['type'] , 
	 *									$entry_data[0]['entry_amount'], $entry_data[0]['name_id'], $entry_data[0]['name_reference']
	 * @param boolean  	$remarks   		Description of the journal entry	
	 */
	public static function postManualJournalEntry($entry, $entry_data, $remarks = '')
	{
		/* INSERT JOURNAL ENTRY */
		$journal_entry['je_shop_id'] 			= Accounting::getShopId();
		$journal_entry['je_reference_module'] 	= "journal-entry";
		$journal_entry['je_entry_date'] 		= $entry['entry_date'];
		$journal_entry['created_at'] 			= Carbon::now();
		$journal_entry['je_remarks']			= $remarks;

		/* CHECK IF JOURNAL EXIST - IF THERE IS A JOURNAL ID */
		if(!$entry['je_id'])
		{
			$line_data["je_id"] 	= Tbl_journal_entry::insertGetId($journal_entry);
		}
		else
		{
			Tbl_journal_entry_line::where("jline_je_id", $entry['je_id'])->delete();
			Tbl_journal_entry::where("je_id", $entry['je_id'])->update($journal_entry);
			$line_data["je_id"] = $entry['je_id'];
		}

		foreach($entry_data as $line)
		{
			
			$line_data["jline_name_id"]			= $line["name_id"];
			$line_data["jline_name_reference"]	= $line["name_reference"];
			$line_data["item_id"]				= 0;
			$line_data["account_id"]			= $line["account_id"];
			$line_data["entry_type"]			= $line["type"];
			$line_data["entry_amount"]			= $line["entry_amount"];

			Accounting::insertJournalLine($line_data);
		}

		return $line_data["je_id"];
	}

	public static function insertJournalLine($line)
	{
		$journal_line['jline_je_id']			= $line["je_id"];
		$journal_line['jline_name_id']			= $line["jline_name_id"];
		$journal_line['jline_name_reference']	= $line["jline_name_reference"];
		$journal_line['jline_item_id'] 			= $line["item_id"];
		$journal_line['jline_account_id'] 		= $line["account_id"];
		$journal_line['jline_type'] 			= $line["entry_type"];
		$journal_line['jline_amount'] 			= $line["entry_amount"];
		$journal_line['jline_description'] 		= isset($line["entry_description"]) ? $line["entry_description"] : '';
		$journal_line["created_at"]				= Carbon::now();

		Tbl_journal_entry_line::insert($journal_line);
	}

	/**
	 * Getting normal balance of the given account
	 *
	 * @param 	string  	$account_id 	account id of specific account
	 * @return 	string 						Credit or Debit
	 */
	public static function normalBalance($account_id)
	{
		$balance = Tbl_chart_of_account::type()->where("account_id", $account_id)->pluck("normal_balance");
		if($balance == "credit") 	return 'Credit';
		elseif($balance == "debit") return 'Debit';
	}

	/**
	 * Getting reverse normal balance of the given account
	 *
	 * @param 	string  	$account_id 	account id of specific account
	 * @return 	string 						Credit or Debit
	 */
	public static function contraAccount($account_id)
	{
		$balance = Tbl_chart_of_account::type()->where("account_id", $account_id)->pluck("normal_balance");
		if($balance == "credit") 	return 'Debit';
		elseif($balance == "debit") return 'Credit';
	}

	/**
	 * Check what table reference and type ( CURRENTLY FUNCTION NOT IN USE! )
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
	 * Check transaction whether it is customer or vendor type; normal balace or contra account; receivable or payable;
	 *
	 * @param 	string  	$type 		Type of a transaction
	 * @return 	array[3]	is_receivable | name | journal	
	 */
	public static function checkTransaction($type)
	{
		switch($type)
		{
			case 'estimate':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'sales-order':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'invoice':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'credit-memo':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'contraAccount';
				return $data;
				break;
			case 'sales-receipt':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'receive-payment':
				$data["is_receivable"]	= true;
				$data["name"] 			= 'customer';
				$data["journal"] 		= 'contraAccount';
				return $data;
				break;
			case 'purchase-order':
				$data["is_receivable"]	= false;
				$data["name"] 			= 'vendor';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'bill':
				$data["is_receivable"]	= false;
				$data["name"] 			= 'vendor';
				$data["journal"] 		= 'normalBalance';
				return $data;
				break;
			case 'bill-payment':
				$data["is_receivable"]	= false;
				$data["name"] 			= 'vendor';
				$data["journal"] 		= 'contraAccount';
				return $data;
				break;
			default:
				$data = null;
		}
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
            $insert["account_shop_id"]          = Accounting::getShopId();
            $insert["account_type_id"]          = 8;
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
            $insert["account_type_id"]          = 11;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Discount";
            $insert["account_description"]      = "Sale Discount";
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
            $insert["account_type_id"]          = 11;
            $insert["account_number"]           = "00000";
            $insert["account_name"]             = "Discount";
            $insert["account_description"]      = "Purchase Discount";
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