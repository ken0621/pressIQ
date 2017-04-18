<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_chart_of_account extends Model
{
	protected $table = 'tbl_chart_of_account';
	protected $primaryKey = "account_id";
    public $timestamps = false;
    
    public function scopeAccountInfo($query, $shop)
    {
        return $query->join('tbl_chart_account_type','account_type_id','=','chart_type_id')
              ->join('tbl_shop','shop_id','=','account_shop_id')
              ->where( function ($where) use($shop)
              {
                    $where->where("shop_id", $shop)
                          ->orWhere("shop_key", $shop);
              });
    }

    public function scopeAccountType($query)
    {
      return $query->join('tbl_chart_account_type','account_type_id','=','chart_type_id');
    }

    public function scopegetbytype($query, $shop_id, $account_type_id = array())
    {
        $query->where('account_shop_id', $shop_id)
              ->whereIn('account_type_id', $account_type_id);
        return $query;
    }
}