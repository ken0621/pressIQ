<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPayrollApproverGroupLevel1272017156pm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payroll_approver_group_level', function (Blueprint $table)
        {
            $table->increments("payroll_approver_group_level_id");
            $table->integer("payroll_approver_group_id")->references('payroll_approver_group_id')->on('tbl_payroll_approver_group')->onDelete('cascade');
            $table->integer("payroll_approver_group_level");
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
