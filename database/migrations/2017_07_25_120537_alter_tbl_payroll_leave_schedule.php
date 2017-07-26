<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblPayrollLeaveSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('tbl_payroll_leave_schedule', function (Blueprint $table) {
            //
            $table->decimal('leave_hours', 8, 2)->change()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
        $sql = "CHANGE `leave_hours` `leave_hours` time NOT NULL DEFAULT '00:00:00' AFTER `shop_id` AFTER `shop_id`";
        DB::connection()->getPdo()->exec($sql);
        });
    }
}
