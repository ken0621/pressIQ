<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblPayrollTimeSheetV8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_payroll_time_sheet', function (Blueprint $table) {
            $table->tinyInteger('is_break_update')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_payroll_time_sheet', function (Blueprint $table) {
            //
        });
    }
}
