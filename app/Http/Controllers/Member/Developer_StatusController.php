<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use DB;
use Request;
use App\Globals\Item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_journal_entry;
class Developer_StatusController extends Member
{
	public function index()
	{
		return view('member.developer.developer_status');
	}
	public function reset_slot()
	{
		return view('member.developer.mlm.resetslot');
	}
	public function reset_slot_submit()
	{
		$password = Request::input('password');
		if($password == 'water123')
		{
			$shop_id = $this->user_info->shop_id;

			$slots =  DB::table('tbl_mlm_slot')->where('tbl_mlm_slot.shop_id', $shop_id)->get();
			$slots_where_in = [];
			foreach($slots as $key => $value)
			{
				$slots_where_in[$key] = $value->slot_id;
			}

			
			$encashment_process = DB::table('tbl_mlm_encashment_process')->where('shop_id', $shop_id)->get();
			$encashment_process_filtered = [];
			foreach ($encashment_process as $key => $value) 
			{
			 	# code...
			 	$encashment_process[$key] = $value->encashment_process;
			 } 

			
			$tbl_membership_code_invoice = DB::table('tbl_item_code_invoice')->where('shop_id', $shop_id)->get();
			$tbl_membership_code_invoice_filtered = [];

			foreach ($tbl_membership_code_invoice as $key => $value) 
			{
				$tbl_membership_code_invoice_filtered[$key] = $value->item_code_invoice_id;
			}
			
			DB::table('tbl_mlm_encashment_process_details')->whereIn('encashment_process', $encashment_process)->delete();
			DB::table('tbl_mlm_slot_wallet_log')->whereIn('wallet_log_slot', $slots_where_in)->delete();
			DB::table('tbl_tree_placement')->whereIn('placement_tree_parent_id', $slots_where_in)->delete();
			DB::table('tbl_tree_sponsor')->whereIn('sponsor_tree_parent_id', $slots_where_in)->delete();
			DB::table('tbl_mlm_slot_points_log')->whereIn('points_log_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_plan_binary_promotions_log')->whereIn('promotions_request_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_lead')->whereIn('lead_slot_id_sponsor', $slots_where_in)->delete();
			DB::table('tbl_mlm_gc')->whereIn('mlm_gc_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_binary_report')->whereIn('binary_report_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_binary_pairing_log')->whereIn('pairing_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_slot')->where('tbl_mlm_slot.shop_id', $shop_id)->delete();
			DB::table('tbl_membership_code')->where('shop_id', $shop_id)->delete();
			DB::table('tbl_membership_code_invoice')->where('shop_id', $shop_id)->delete();
			DB::table('tbl_membership_code_item_has')->where('shop_id', $shop_id)->delete();
			DB::table('tbl_mlm_encashment_process')->where('shop_id', $shop_id)->delete();
			DB::table('tbl_item_code')->where('shop_id', $shop_id)->delete();
			DB::table('tbl_item_code_item')->whereIn('item_code_invoice_id', $tbl_membership_code_invoice_filtered)->delete();
			DB::table('tbl_item_code_invoice')->where('shop_id', $shop_id)->delete();
		}
		else
		{
			die('Wrong Password');
		}
		die('Success');
	}
	public function give_points_ec_order()
	{
		$password = Request::input('password');
		if($password == 'water123')
		{
			$id = Request::input('id');
			Item_code::use_item_code_all_ec_order($id);
			die('success');
		}
		die('wrong password');
	}
	public function retro_product_sales()
	{
		$shop_id = $this->user_info->shop_id;
		$sales = Tbl_item_code_invoice::where('shop_id', $shop_id)->get();
		$password = Request::input('password');
		if($password == 'water123')
		{
			foreach($sales as $key => $value)
			{
				$count = Tbl_journal_entry::where('je_reference_module','=', 'mlm-product-repurchase')
				->where('je_reference_id', $value->item_code_invoice_id)
				->count();
				if($count == 0)
				{
					Item_code::add_journal_entry($value->item_code_invoice_id);
				}
			}
			return 'Success';
		}

	}
}