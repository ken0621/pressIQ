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
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
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
			$data["journal"] = Tbl_journal_entry::where("je_id", $je_id)->first();
			$data["journal"]["line"] = Tbl_journal_entry_line::where("jline_je_id", $data["journal"]->je_id)->get();
		}

		return view('member.accounting.journal_ledger.manual_journal_entry', $data);
	}

	public function getEntry($module, $id)
	{
		$data['_journal'] = Tbl_journal_entry::transaction($module)->where("je_reference_id", $id)->get();
		foreach($data['_journal'] as $key=>$journal)
		{
			$customer_vendor = Accounting::checkTransactionName($journal->je_reference_module);
			$data['_journal'][$key]->entries = Tbl_journal_entry_line::account()->item()->customerOrVendor($customer_vendor)->where("jline_je_id", $journal->je_id)->orderBy("jline_type","desc")->orderBy("account_name")->get();
		}

		return view('member.accounting.journal_ledger.journal_entry', $data);
	}

	public function getManualJournalEntry()
	{

	}

	public function postManualJournalEntry()
	{
		$debit 	= Request::input("jline_debit");
		$credit = Request::input("jline_credit");
		/* Validation */
		$total_debit 	= collect(array_map(function($e){return convertToNumber($e);}, $debit))->sum();
		$total_credit 	= collect(array_map(function($e){return convertToNumber($e);}, $credit))->sum();

		if($total_debit == $total_credit)
		{
			foreach(Request::input("jline_account_id") as $key=>$account_id)
			{
				if($account_id)
				{
					$entry["entry_date"] = datepicker_input(Request::input("je_entry_date"));

					$entry_data[$key]["account_id"] 	= Request::input("jline_account_id")[$key];
					$entry_data[$key]["type"] 			= $debit[$key] != "" ? 'debit' : ($credit[$key] != "" ? 'credit' : "");
					$entry_data[$key]["entry_amount"] 	= $debit[$key] != "" ? $debit[$key] : ($credit[$key] != "" ? $credit[$key] : "");
					$entry_data[$key]["name_id"] 		= Request::input("jline_name_id")[$key];
					$entry_data[$key]["name_reference"] = Request::input("jline_name_reference")[$key];
				}
			}

			$je_id = Accounting::postManualJournalEntry($entry, $entry_data, "");

			$json["status"] 	= "success";
			$json["message"] 	= "Success";
			$json["je_id"]		= $je_id;
		}
		else
		{
			$json["status"]	= "error";
			$json["message"] = "Please balance debits and credits.";
		}

		return json_encode($json);
	}
}