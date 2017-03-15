<?php
namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Tbl_ec_product extends Model
{
	protected $table = 'tbl_ec_product';
	protected $primaryKey = "eprod_id";
    public $timestamps = false;

    public function scopeVariant($query, $separator = ' • ' )
    {
    	$query->selectRaw("eprod_id, eprod_name, evariant_id, group_concat(option_value ORDER BY variant_name_order ASC SEPARATOR '$separator') as variant_name, evariant_item_id, evariant_item_label, evariant_description, evariant_price")
    		  ->join("tbl_ec_variant","eprod_id","=","evariant_prod_id")
    		  ->leftjoin(DB::raw("tbl_variant_name as var_name"),"evariant_id","=", "variant_id")
    		  ->leftjoin(DB::raw("tbl_option_name as op_name"),"op_name.option_name_id","=","var_name.option_name_id")
    		  ->leftjoin(DB::raw("tbl_option_value as op_value"),"op_value.option_value_id","=","var_name.option_value_id")
    		  ->groupBy("evariant_id");
    }

    public function scopeVariantOption($query, $separator = ',')
    {
    	$query->selectRaw("eprod_id, op_name.option_name_id, option_name, concat(eprod_id,'-',option_name) AS variant_name, group_concat(distinct option_value order by variant_name_order ASC separator '$separator') AS variant_value")
    		  ->join("tbl_ec_variant","eprod_id","=","evariant_prod_id")
    		  ->join(DB::raw('tbl_variant_name as var_name'), "evariant_id", "=", "variant_id")
    		  ->join(DB::raw('tbl_option_name as op_name'), "var_name.option_name_id", "=", "op_name.option_name_id")
    		  ->join(DB::raw('tbl_option_value as op_value'), "var_name.option_value_id", "=", "op_value.option_value_id")
    		  ->groupBy(DB::raw("concat(eprod_id,'-',op_name.option_name)"))
    		  ->orderBy("variant_name_order");

    }

    public function scopeItem($query)
    {
    	$query->join("tbl_item","item_id","=","evariant_item_id");
    }

    public function scopePrice($query)
    {
        $query->selectRaw("tbl_ec_product.*, min(evariant_price) as min_price, max(evariant_price) as max_price")
              ->join("tbl_ec_variant","evariant_prod_id","=","eprod_id")
              ->groupBy("eprod_id");
    }

    public function scopeCategory($query)
    {
        return $query->join("tbl_category","type_id","=","eprod_category_id");
    }
}