<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_journal_entry_line extends Model
{
	protected $table = 'tbl_journal_entry_line';
	protected $primaryKey = "jline_id";
    public $timestamps = false;

    public function scopeAccount($query)
    {
    	return $query->join("tbl_chart_of_account", "account_id", "=", "jline_account_id")
    				 ->join("tbl_chart_account_type", "chart_type_id", "=", "account_type_id");
    }

    public function scopeItem($query)
    {
    	return $query->leftjoin("tbl_item", "item_id", "=", "jline_item_id");
        
        // {{$um->multi_name}} ({{$um->multi_abbrev}}
    }

    public function scopeCustomerOrVendor($query, $type = null)
    {
        if($type == 'customer')
        {
            return $query->selectRaw("*, concat(first_name, ' ', middle_name,' ', last_name) as 'full_name'")
                        ->leftJoin("tbl_customer", "customer_id", "=", "jline_name_id");
        }
        elseif($type == 'vendor')
        {
            return $query->selectRaw("*, concat('vendor_first_name', 'vendor_middle_name', 'vendor_last_name') as 'full_name'")
                        ->leftJoin("tbl_vendor", "vendor_id", "=", "jline_name_id");
        }
    }

    public function scopeSelectedLimit($query)
    {
        return $query->select("jline_item_id","jline_account_id","jline_type","jline_amount","jline_description");
    }

    public function scopeJournal($query)
    {
        return $query->join("tbl_journal_entry","je_id","=","jline_je_id");
    }
    public function scopeSelectSales($query)
    {
        $sales_account[0] = 'Income';
        $sales_account[1] = 'Other Income';
        
        $query->whereIn('chart_type_name', $sales_account);

        return $query;
    }
    public function scopeJoinReciept($query)
    {
        $query->leftJoin('tbl_item_code_invoice.item_code_invoice_id as code_invoice, tbl_item_code_invoice.', function($join){
            $join->on('code_invoice.item_code_invoice_id', '=', 'je_reference_id');
            $join->where('je_reference_module', '=', DB::raw('mlm-product-repurchase'));
        });
        return $query; 
    }
    public function scopeConcatUm($query)
    {
        $query->leftjoin('tbl_unit_measurement', 'tbl_unit_measurement.um_id','=', 'tbl_item.item_measurement_id')
        ->leftjoin("tbl_unit_measurement_multi","multi_um_id","=","um_id")
        ->selectRaw("concat(multi_name, ':', multi_abbrev) as 'z_um'");
        
        return $query;
    }
}