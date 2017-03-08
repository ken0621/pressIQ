<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_mlm_slot extends Model
{
	protected $table = 'tbl_mlm_slot';
	protected $primaryKey = "slot_id";
    public $timestamps = false;
    
    public function scopeId($query, $slot_id)
    {
        return $query->where("slot_id", $slot_id);
    }
    
    public function scopeMembership($query)
    {
        $query->join('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership');
	    return $query;
    }
    public function scopeMembership_points($query)
    {
        $query->leftjoin('tbl_membership_points', 'tbl_membership_points.membership_id', '=', 'tbl_membership.membership_id');
        return $query;
    }
    public function scopeMembershipcode($query)
    {
        $query->leftjoin('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id');
        return $query;
    }
    public function scopeCustomer($query)
    {
        $query->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner');
        
        // ->where('tbl_customer_address.purpose', 'billing');

        // ->leftjoin('tbl_customer_other_info', 'tbl_customer_other_info.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        // ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_mlm_slot.slot_owner')
	    return $query;
    }
}
