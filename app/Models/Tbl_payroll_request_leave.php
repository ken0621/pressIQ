<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_payroll_request_leave extends Model
{
    //
    protected $table = 'tbl_payroll_request_leave';
	protected $primaryKey = "payroll_request_leave_id";
    public $timestamps = false;

    public function scopeEmployeeInfo($query)
    {
    	$query->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_request_leave.payroll_employee_id');

    	return $query;
    }

    public function scopeGetAllRequest($query, $approver_employee_id = 0 , $approver_employee_level = 0, $status = '')
    {
	  $query->join('tbl_payroll_approver_group', 'tbl_payroll_approver_group.payroll_approver_group_id', '=', 'tbl_payroll_request_leave.payroll_approver_group_id')
		  	->join('tbl_payroll_approver_group_employee','tbl_payroll_approver_group_employee.payroll_approver_group_id','=','tbl_payroll_approver_group.payroll_approver_group_id')
          	->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_request_leave.payroll_employee_id')
            ->leftjoin('tbl_payroll_employee_basic as basic_reliever','basic_reliever.payroll_employee_id', '=','tbl_payroll_request_leave.payroll_request_leave_id_reliever')
            ->select('tbl_payroll_approver_group.*','tbl_payroll_approver_group_employee.*','tbl_payroll_employee_basic.*','tbl_payroll_request_leave.*','basic_reliever.payroll_employee_display_name as reliever_name');

	
  		
      if ($approver_employee_id != 0) 
      {
          $query->where('tbl_payroll_approver_group_employee.payroll_approver_employee_id', $approver_employee_id);
      }

      if ($approver_employee_level != 0) 
      {
           $query->where('tbl_payroll_request_leave.payroll_request_leave_status_level', $approver_employee_level);
      }

      if ($status != '') 
      {
      	 $query->where('tbl_payroll_request_leave.payroll_request_leave_status', $status);
      }

      return $query;
    }

    public function scopeGetAllRequestByStatusAndLevel($query, $approver_employee_id = 0 , $approver_employee_level = 0)
    {
	  $query->join('tbl_payroll_approver_group', 'tbl_payroll_approver_group.payroll_approver_group_id', '=', 'tbl_payroll_request_leave.payroll_approver_group_id')
		  	->join('tbl_payroll_approver_group_employee','tbl_payroll_approver_group_employee.payroll_approver_group_id','=','tbl_payroll_approver_group.payroll_approver_group_id')
          	->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_request_leave.payroll_employee_id');
		
		
      if ($approver_employee_id != 0) 
      {
          $query->where('tbl_payroll_approver_group_employee.payroll_approver_employee_id', $approver_employee_id);
      }

      if ($approver_employee_level != 0) 
      {
           $query->where('tbl_payroll_request_leave.payroll_request_leave_status_level', $approver_employee_level);
      }

      return $query;
    }

    public function scopeGetLeaveInfo($query, $payroll_employee_id, $leaveemployeeid)
    {
      $query->join('tbl_payroll_leave_employee_v2','tbl_payroll_request_leave.payroll_leave_employee_id','=','tbl_payroll_leave_employee_v2.payroll_leave_employee_id')
             ->select(DB::raw('tbl_payroll_leave_employee_v2.payroll_leave_temp_hours, sum(tbl_payroll_request_leave.consume) as total_leave_consume, (tbl_payroll_leave_employee_v2.payroll_leave_temp_hours - sum(tbl_payroll_request_leave.consume)) as remaining_leave'))
             ->groupBy('tbl_payroll_leave_employee_v2.payroll_leave_temp_id')
       ->where('tbl_payroll_leave_employee_v2.payroll_employee_id', $payroll_employee_id)
       ->where('tbl_payroll_leave_employee_v2.payroll_leave_employee_id', $leaveemployeeid)
       ->where('tbl_payroll_request_leave.payroll_leave_employee_id', $leaveemployeeid)
       ->where('tbl_payroll_request_leave.archived',0)->where('payroll_request_leave_status','approved');

       return $query;
    }

    public function scopeGetLeaveInfoV2($query, $payroll_employee_id, $leaveemployeeid)
    {
      $query->join('tbl_payroll_leave_employee_v2','tbl_payroll_request_leave.payroll_leave_employee_id','=','tbl_payroll_leave_employee_v2.payroll_leave_employee_id')
             ->select(DB::raw('tbl_payroll_request_leave.payroll_request_leave_type, tbl_payroll_leave_employee_v2.payroll_leave_temp_hours, sum(tbl_payroll_request_leave.consume) as total_leave_consume, (tbl_payroll_leave_employee_v2.payroll_leave_temp_hours - sum(tbl_payroll_request_leave.consume)) as remaining_leave'))
             ->groupBy('tbl_payroll_leave_employee_v2.payroll_leave_temp_id')
       ->where('tbl_payroll_leave_employee_v2.payroll_employee_id', $payroll_employee_id)
       ->whereIn('tbl_payroll_leave_employee_v2.payroll_leave_employee_id', $leaveemployeeid)
       ->whereIn('tbl_payroll_request_leave.payroll_leave_employee_id', $leaveemployeeid)
       ->where('tbl_payroll_request_leave.archived',0)->where('payroll_request_leave_status','approved');

       return $query;
    }
}
