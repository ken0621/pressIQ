<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPayrollApproverGroupLevelEmployee1272017156pm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payroll_approver_group_level_employee', function (Blueprint $table)
        {
            $table->increments("payroll_approver_group_level_employee_id");
            $table->integer("payroll_approver_group_level_id")->references('tbl_payroll_approver_group_level_id')->on('tbl_payroll_approver_group_level')->onDelete('cascade');
            $table->integer("payroll_approver_employee_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
