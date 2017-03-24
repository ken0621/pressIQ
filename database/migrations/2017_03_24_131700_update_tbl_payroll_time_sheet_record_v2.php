<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblPayrollTimeSheetRecordV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_payroll_time_sheet_record', function (Blueprint $table) {
            $table->integer('payroll_time_sheet_id')->unsigned()->change();
            $table->foreign('payroll_time_sheet_id')->references('payroll_time_sheet_id')->on('tbl_payroll_time_sheet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_payroll_time_sheet_record', function (Blueprint $table) {
            //
        });
    }
}
