<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership extends Model
{
    protected $table = 'tbl_membership';
	protected $primaryKey = "membership_id";
    public $timestamps = false;
    public function scopeArchive($query, $archive=0)
    {
        $query->where('membership_archive', $archive);
    	return $query;
    }
    public function scopeId($query, $membership_id=0)
    {
        $query->where('membership_id', $membership_id);
    	return $query;
    }
    public function scopeMembership_points($query)
    {
        $query->selectRaw('tbl_membership_points.membership_points_repurchase, tbl_membership_points.membership_points_direct_not_bonus, tbl_membership_points.membership_points_leadership, tbl_membership_points.membership_points_binary, tbl_membership_points.membership_points_executive, tbl_membership_points.membership_points_binary_max_pair, tbl_membership_points.membership_points_direct, tbl_membership_points.membership_points_initial_points, tbl_membership_points.membership_points_repurchase_cashback, tbl_membership_points.membership_points_binary_limit, tbl_membership_points.membership_points_binary_single_line, tbl_membership_points.membership_points_binary_single_line_limit' )
        ->leftjoin('tbl_membership_points', 'tbl_membership_points.membership_id', '=', 'tbl_membership.membership_id');
        return $query;
    }
    public function scopeGetactive($query, $archive=0, $shop_id)
    {
        $query->where('membership_archive', $archive)
        ->leftjoin('tbl_membership_package', 'tbl_membership_package.membership_id', '=', 'tbl_membership.membership_id')
        ->groupBy('tbl_membership.membership_id')
        ->selectRaw('tbl_membership.*,
        COUNT(CASE WHEN tbl_membership_package.membership_package_archive = 0 THEN 1 END) package_count, 
        COUNT(CASE WHEN tbl_membership_package.membership_package_archive = 1  THEN 1 END) package_count_archive')
        ->where('tbl_membership.shop_id', $shop_id)
        ->where('membership_type_a', 0)
        ->orderby('membership_price', 'ASC');
        return $query;
    }
    public function scopeGetbinarypairing($query)
    {
        // tbl_mlm_binary_pairing
        $query->leftjoin('tbl_mlm_binary_pairing','tbl_mlm_binary_pairing.membership_id',"=",'tbl_membership.membership_id');
        return $query;
        
    }
    public function scopeExecutive_settings($query)
    {
        $query->leftjoin('tbl_mlm_complan_executive_settings', 'tbl_mlm_complan_executive_settings.membership_id', '=', 'tbl_membership.membership_id');
        return $query;
    }
}
