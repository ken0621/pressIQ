<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use DB;
use Request;
use Crypt;
use App\Globals\Item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_tree_sponsor;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_tree;
use App\Globals\Mlm_complan_manager;
use App\Models\Tbl_item_code;
use App\Globals\Mlm_complan_manager_repurchase;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Globals\Mlm_plan;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_customer_search;
use Carbon\Carbon;
use Excel;
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

			DB::table('tbl_mlm_triangle_repurchase_slot')->whereIn('repurchase_slot_slot_id', $slots_where_in)
			->join('tbl_mlm_triangle_repurchase_tree', 'tbl_mlm_triangle_repurchase_tree.tree_repurchase_slot_child', '=', 'tbl_mlm_triangle_repurchase_slot.repurchase_slot_id')
			->truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
		}
		else
		{
			die('Wrong Password');
		}
		die('Success');
	}
	public function recompute()
	{
		$shop_id = $this->user_info->shop_id;
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
			
			// DB::table('tbl_mlm_encashment_process_details')->whereIn('encashment_process', $encashment_process)->delete();
			DB::table('tbl_mlm_slot_wallet_log')->whereIn('wallet_log_slot', $slots_where_in)->delete();
			DB::table('tbl_tree_placement')->whereIn('placement_tree_parent_id', $slots_where_in)->delete();
			DB::table('tbl_tree_sponsor')->whereIn('sponsor_tree_parent_id', $slots_where_in)->delete();
			// DB::table('tbl_mlm_slot_points_log')->whereIn('points_log_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_plan_binary_promotions_log')->whereIn('promotions_request_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_lead')->whereIn('lead_slot_id_sponsor', $slots_where_in)->delete();
			DB::table('tbl_mlm_gc')->whereIn('mlm_gc_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_binary_report')->whereIn('binary_report_slot', $slots_where_in)->delete();
			DB::table('tbl_mlm_binary_pairing_log')->whereIn('pairing_slot', $slots_where_in)->delete();
			// DB::table('tbl_mlm_slot')->where('tbl_mlm_slot.shop_id', $shop_id)->delete();
			// DB::table('tbl_membership_code')->where('shop_id', $shop_id)->delete();
			// DB::table('tbl_membership_code_invoice')->where('shop_id', $shop_id)->delete();
			// DB::table('tbl_membership_code_item_has')->where('shop_id', $shop_id)->delete();
			// DB::table('tbl_mlm_encashment_process')->where('shop_id', $shop_id)->delete();
			// DB::table('tbl_item_code')->where('shop_id', $shop_id)->delete();
			// DB::table('tbl_item_code_item')->whereIn('item_code_invoice_id', $tbl_membership_code_invoice_filtered)->delete();
			// DB::table('tbl_item_code_invoice')->where('shop_id', $shop_id)->delete();

			foreach($slots as $key => $value)
			{
				$update['slot_binary_left'] = 0;
				$update['slot_binary_right'] = 0;
				$update['slot_wallet_all'] = 0;
				$update['slot_wallet_current'] = 0;
				$update['slot_pairs_per_day_date'] = Carbon::now()->addDays(-2);
				Tbl_mlm_slot::where('slot_id', $value->slot_id)->update($update);

				Mlm_compute::entry($value->slot_id);
			}
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
	public function re_tree()
	{

		$slot_id = Request::input('id');
		$slot_info = Mlm_compute::get_slot_info($slot_id);
		if($slot_info)
		{
			Tbl_tree_sponsor::where('sponsor_tree_child_id', $slot_id)->delete();
			return Mlm_tree::insert_tree_sponsor($slot_info, $slot_info, 1);
		}
	}
	public function re_com_phil_lost()
	{
		$slot_id = Request::input('id');
		$slot_info = Mlm_compute::get_slot_info($slot_id);
		if($slot_info)
		{
			Mlm_complan_manager::indirect($slot_info);
			Mlm_complan_manager::membership_matching($slot_info);
			Mlm_complan_manager::indirect_points($slot_info);
		}
	}
	public function re_com_phil_uni()
	{
		$member_ship = 2;
		$invoice = Tbl_item_code_invoice::customer()
		->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')
		->where('slot_membership', 2)
		->get();
		foreach($invoice as $key => $value)
		{
			$slot_info = Mlm_compute::get_slot_info($value->slot_id);
			$item_code = Tbl_item_code::where("item_code_invoice_id",$value->item_code_invoice_id)->get(); 
			foreach($item_code as $key2 => $value2)
			{
				Mlm_complan_manager_repurchase::unilevel_repurchase_points($slot_info, $value2->item_code_id);
			}
			
		}
		dd($invoice);
	}
	public function recompute_myphone()
	{
		ini_set('max_execution_time', 5000);
		$password = Request::input('password');
		if($password == 'water123')
		{
			DB::table('tbl_tree_placement')->delete();
			DB::table('tbl_tree_sponsor')->delete();
			DB::table('tbl_mlm_slot_wallet_log')->delete();
			
			// JESUS CHAM 351           15 - 1   (4187)
			// CHRISTIAN PARO-AN 352    33 - 5   (4196, 4185, 4182, 4180, 4176)
			// KELVIN CHAM 354		  4 - 1	  (4192)
			// JOHN PAUL HORNEDO 361     2 - 1	  (4209)
			$whereIn['4187'] = 4187;
			$whereIn['4196'] = 4196;
			$whereIn['4185'] = 4185;
			$whereIn['4182'] = 4182;
			$whereIn['4180'] = 4180;
			$whereIn['4176'] = 4176;
			$whereIn['4192'] = 4192;
			$whereIn['4209'] = 4209;
			Tbl_mlm_slot::whereIn('slot_id', $whereIn)->delete();

			$update['slot_placement'] = 0;
			$update['slot_position'] = 'left';
			$update['current_level'] = 0;
			$update['auto_balance_position'] = 1;
			
			Tbl_mlm_slot::orderBy('slot_id', 'ASC')->update($update);
			$slots = Tbl_mlm_slot::orderBy('slot_created_date', 'ASC')->get();
			foreach ($slots as $key => $value) {
				Mlm_compute::entry($value->slot_id);
			}
		}
		dd('ok');
	}
	public function import_excel()
	{
		$shop_id = $this->user_info->shop_id;
		Excel::load(public_path().'/assets/mlm/brown.xlsx', function($reader) 
            {
                $results = $reader->get()->toArray();
                $restructure = [];
                $shop_id = $this->user_info->shop_id;
                foreach($results[0] as $key => $value)
                {
                    
                    $id = $value['id'];
                    $first_name = $value['first_name'];
                    $middle_name = $value['middle_name'];
                    $last_name = $value['last_name']; 
                    $email = $value['email']; 
                    $contact = $value['contact']; 
                    $sponsor_id = $value['sponsor_id']; 
                    $tin = $value['tin']; 
                    if($first_name == null)
                    {
                        $this->import_excel_v2($restructure);
                        dd(1);
                    }
                    $insert['shop_id'] = $shop_id;
                    $insert['country_id'] = 420;
                    $insert['title_name'] = '';
                    $insert['first_name'] =  $first_name;
                    $insert['middle_name'] = $middle_name;
                    $insert['last_name'] = $last_name;
                    $insert['suffix_name'] = '';
                    $insert['email'] =   $email;
                    $insert['ismlm'] = 1;
                    $insert['mlm_username'] = $this->generate_username($first_name, $last_name);
                    $insert['password'] = 'myphone';
                    $insert['tin_number'] = $tin;
                    $insert['company'] = '';
                    $insert['created_date'] = Carbon::now();

                    $customer_id = Tbl_customer::insertGetId($insert);

                    $restructure[$id]['customer_id'] = $customer_id;
                    $restructure[$id]['sponsor_id'] = $sponsor_id;
                    
                    $insertSearch['customer_id'] = $customer_id;
                    $insertSearch['body'] = $insert['title_name'].' '.$insert['first_name'].' '.$insert['middle_name'].' '.$insert['last_name'].' '.$insert['suffix_name'].' '.$insert['email'].' '.$insert['company'];

                    Tbl_customer_search::insert($insertSearch);

                    $insertInfo['customer_id'] = $customer_id;
                    $insertInfo['customer_mobile'] = $contact;
                    Tbl_customer_other_info::insert($insertInfo);

                    $insertAddress[0]['customer_id'] = $customer_id;
                    $insertAddress[0]['country_id'] = 420;
                    $insertAddress[0]['purpose'] = 'billing';
                    $insertAddress[0]['customer_street'] = '';
                    
                    $insertAddress[1]['customer_id'] = $customer_id;
                    $insertAddress[1]['country_id'] = 420;
                    $insertAddress[1]['purpose'] = 'shipping';
                    $insertAddress[1]['customer_street'] = '';
                    Tbl_customer_address::insert($insertAddress);
                }
            });

			
	}
	public function import_excel_v2($restructure)
	{
		$shop_id = $this->user_info->shop_id;
		foreach ($restructure as $key => $value) 
		{
            $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, null);
            $insert['shop_id'] = $shop_id;
            $insert['slot_owner'] = $value['customer_id'];
            $insert['slot_created_date'] = Carbon::now();
            $insert['slot_membership'] =  7;
            $insert['slot_status'] = 'PS';
            if(isset($restructure[$value['sponsor_id']]['slot_id']))
            {
                 $insert['slot_sponsor'] = $restructure[$value['sponsor_id']]['slot_id'];
            }
            $id = Tbl_mlm_slot::insertGetId($insert);
            $restructure[$key]['slot_id'] = $id;
            $a = Mlm_compute::entry($id, 0);
		}
	}
	public function generate_username($first_name, $last_name)
    {
        $f_name = $first_name;
        $l_name = $last_name;
        $last_name = str_replace(' ', '', $last_name);
        $first_name = str_replace(' ', '', $first_name);
        $last_name = strtolower(substr($last_name, 0, 3));
        $first_name = strtolower(substr($first_name, 0, 6));
        $nickname = $first_name . '.' . $last_name;
        $count_username = Tbl_customer::where('first_name', $f_name)
        ->where('last_name', $l_name)
        ->count();
        if($count_username == 0)
        {
            return $nickname;
        }
        else
        {
            $nickname = $nickname . ($count_username + 1);
            return $nickname;
        }
    }
    public function fix_password()
    {
    	$password = Crypt::encrypt('myphone');
    	$update['password'] = $password;
    	Tbl_customer::where('password', 'myphone')->update($update);
    	dd(1);
    }
}