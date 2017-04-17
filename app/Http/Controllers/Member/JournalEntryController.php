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
	public function getIndex($type)
	{
		return view('member.accounting.journal_ledger.journal_entry');
	}

	public function getEntry($module, $id)
	{
		$data['_journal'] = Tbl_journal_entry::transaction($module)->where("je_reference_id", $id)->get();
		foreach($data['_journal'] as $key=>$journal)
		{
			$data['_journal'][$key]->entries = Tbl_journal_entry_line::account()->item()->where("jline_je_id", $journal->je_id)->get();
		}

		return view('member.accounting.journal_ledger.journal_entry', $data);
	}
}