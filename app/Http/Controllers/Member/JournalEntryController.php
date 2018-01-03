<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_item;
use App\Models\Tbl_user;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_customer;
use App\Models\Tbl_vendor;
use App\Models\Tbl_chart_of_account;

use App\Globals\Accounting;
use App\Globals\Item;

use Carbon\Carbon;
use Request;
use Image;
use Validator;
use Redirect;
use File;
use URL;
use DB;
use Crypt;
use Session;

/**
 * Journal Entries and General Ledger Module - all jouranl and ledger related
 *
 * @author Bryan Kier Aradanas
 */

class JournalEntryController extends Member
{
	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
	}

	public function getList()
	{
		$data['_journal']	= Tbl_journal_entry::where("je_shop_id", $this->getShopId())->where("je_reference_module", 'journal-entry')->get();
		foreach($data['_journal'] as $key=>$journal)
		{
			$data['_journal'][$key]->total = Tbl_journal_entry_line::where("jline_je_id", $journal->je_id)->where("jline_type", 'Debit')->sum("jline_amount");
		}

		return view('member.accounting.journal_ledger.manual_journal_entry_list', $data);
	}

	/* MANUAL JOURNAL ENTRY */
	public function getIndex()
	{
		$data["_account"] 	= Accounting::getAllAccount("active");
		
		$data["_name"]		= Tbl_customer::unionVendor($this->getShopId())->get();
		$data["action"]		= "/member/accounting/journal/manual-journal-entry";
		$je_id = Request::input("id");
		if($je_id)
		{
			$data["journal"] 		 = Tbl_journal_entry::where("je_id", $je_id)->first();
			$data["journal"]["line"] = Tbl_journal_entry_line::where("jline_je_id", $data["journal"]->je_id)->get();
			$data["action"]			 = "/member/accounting/journal/manual-journal-entry?je_id=".$data["journal"]->je_id;
		}

		return view('member.accounting.journal_ledger.manual_journal_entry', $data);
	}

	public function getAllList()
	{
		$data['_journal']	= Tbl_journal_entry::transaction()->where("je_shop_id", $this->getShopId())->get();
		foreach($data['_journal'] as $key=>$journal)
		{
			$data['_journal'][$key]->total = Tbl_journal_entry_line::where("jline_je_id", $journal->je_id)->where("jline_type", 'Debit')->sum("jline_amount");
		}

		return view('member.accounting.journal_ledger.all_journal_entry_list', $data);
	}

	/**
	 * Global Journal Entries for every journal entry module
	 *
	 * @param 	$module
	 * @param 	$id
	 * @return  query results     - Always one result only
	 */
	public function getEntry($module, $id)
	{
		$data['_journal'] = Tbl_journal_entry::transaction($module)->where("je_reference_id", $id)->get();
		foreach($data['_journal'] as $key=>$journal)
		{
			$data['_journal'][$key]->entries = Tbl_journal_entry_line::account()->item()->customerOrVendor()->where("jline_je_id", $journal->je_id)->orderBy("jline_type","desc")->orderBy("account_name")->get();
		}
		
		return view('member.accounting.journal_ledger.journal_entry', $data);
	}

	/**
	 * Global Journal Entries for all journal entries
	 *
	 * @return  query results
	 */
	public function getAllEntry()
	{
		$date_period = Request::input('period_date') ? Request::input('period_date') : 'all'; 
		$start_date  = Request::input('start_date');
		$end_date    = Request::input('end_date');

		$data['start_date']  = $this->checkDatePeriod($date_period, $start_date, $end_date )['start_date'];
		$data['new_end_date']= $this->checkDatePeriod($date_period, $start_date, $end_date )['end_date'];
		// dd($new_end_date	);
		$data['_journal'] = Tbl_journal_entry::transaction()->where("je_shop_id", $this->getShopId())
							->where(DB::raw("date(je_entry_date)"),">=",$data['start_date'])
							->where(DB::raw("date(je_entry_date)"),"<=",$data['new_end_date'])
							->get();

		foreach($data['_journal'] as $key=>$journal)
		{
			$data['_journal'][$key]->entries = Tbl_journal_entry_line::account()->item()->customerOrVendor()->where("jline_je_id", $journal->je_id)->orderBy("jline_type","desc")->orderBy("account_name")->get();
		}

		$data["date_period"] = 1;

		return view('member.accounting.journal_ledger.journal_entry', $data);
	}

	public function getAllEntryByAccount($account_id)
	{
		$data["account"]	= Tbl_chart_of_account::where("account_id", $account_id)->first();
		$date_period = Request::input('period_date') ? Request::input('period_date') : 'all'; 
		$start_date  = Request::input('start_date');
		$end_date    = Request::input('end_date');

		$new_start_date  = $this->checkDatePeriod($date_period, $start_date, $end_date )['start_date'];
		$new_end_date  	 = $this->checkDatePeriod($date_period, $start_date, $end_date )['end_date'];
		// dd($new_end_date	);
		$data['_journal'] = Tbl_journal_entry_line::account()->journal()->transaction()
							->where("je_shop_id", $this->getShopId())
							->where("jline_account_id", $account_id)
							->where(DB::raw("date(je_entry_date)"),">=",$new_start_date)
							->where(DB::raw("date(je_entry_date)"),"<=",$new_end_date)
							->orderBy("je_entry_date")
							->get();

		// dd($data['_journal']);

		return view('member.accounting.journal_ledger.general_ledger', $data);
	}

	public function checkDatePeriod($period, $start_date, $end_date)
	{
		switch($period)
		{
			case 'all':
				$data["start_date"] = "1000-01-01";
				$data["end_date"]	= "9000-01-01";
				break;
			case 'custom':
				$data["start_date"] = datepicker_input($start_date);
				$data["end_date"]	= datepicker_input($end_date);
				break;
			case 'today':
				$data["start_date"] = datepicker_input("today");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_week':
				$data["start_date"] = datepicker_input("previous sunday");
				$data["end_date"]	= datepicker_input("next saturday");
				break;
			case 'this_week_to_date':
				$data["start_date"] = datepicker_input("previous sunday");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_month':
				$data["start_date"] = datepicker_input("first day of this month");
				$data["end_date"]	= datepicker_input("last day of this month");
				break;
			case 'this_month_to_date':
				$data["start_date"] = datepicker_input("first day of this month");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_year':
				$data["start_date"] = datepicker_input("first day of January");
				$data["end_date"]	= datepicker_input("last day of December");
				break;
		}
		return $data;
	}

	public function postManualJournalEntry()
	{
		$button_action 	= Request::input('button_action');
		$debit 			= Request::input("jline_debit");
		$credit 		= Request::input("jline_credit");

		/* For Validation */
		$total_debit 	= collect(array_map(function($e){return convertToNumber($e);}, $debit))->sum();
		$total_credit 	= collect(array_map(function($e){return convertToNumber($e);}, $credit))->sum();

		if($total_debit == $total_credit)
		{
			$account_type_string = '';
			$account_type_id = 0; 
			foreach(Request::input("jline_account_id") as $key=>$account_id)
			{
				if($account_id)
				{
					$account_type_id = Tbl_chart_of_account::accountInfo($this->getShopId())->where("account_id", $account_id)->value("chart_type_id");
					$account_type_id == 2 ? $account_type_string.='2' : ($account_type_id == 6 ? $account_type_string.='6' : '');

					$entry["entry_date"] = datepicker_input(Request::input("je_entry_date"));
					$entry["je_id"]		 = Request::input("je_id");

					$entry_data[$key]["account_id"] 	= Request::input("jline_account_id")[$key];
					$entry_data[$key]["type"] 			= $debit[$key] != "" ? 'Debit' : ($credit[$key] != "" ? 'Credit' : "");
					$entry_data[$key]["entry_amount"] 	= $debit[$key] != "" ? $debit[$key] : ($credit[$key] != "" ? $credit[$key] : "");
					$entry_data[$key]["name_id"] 		= Request::input("jline_name_id")[$key];
					$entry_data[$key]["name_reference"] = Request::input("jline_name_reference")[$key];
				}
			}

			if((strpos($account_type_string, '2') >= 0 && strpos($account_type_string, '2') !== false) && (strpos($account_type_string, '6') >= 0 && strpos($account_type_string, '6') !== false))
			{
				$json["status"]	= "error";
				$json["message"] = "There must be only one Accounts Receivable and/or Accounts Payable";
	    	}
	    	else
	    	{
	    		$je_id = Accounting::postManualJournalEntry($entry, $entry_data, "");

				$json["status"] 	= "success";
				$json["message"] 	= "Success";
				$json["je_id"]		= $je_id;


				/* ACTION BUTTON OPTION */
				if($button_action == "save-and-edit")	
		        {
		            $json["redirect"]   = "/member/accounting/journal?id=".$je_id;
		        }
		        elseif($button_action == "save-and-new")
		        {
		            $json["redirect"]   = "/member/accounting/journal";
		        }
		        elseif($button_action == "save-and-close")
		        {
		        	$json["redirect"]   = "/member/accounting/journal/list";
		        }
		        Request::session()->flash('success', 'Success');
	    	}
		}
		else
		{
			$json["status"]	= "error";
			$json["message"] = "Please balance debits and credits.";
		}

		return json_encode($json);
	}
}