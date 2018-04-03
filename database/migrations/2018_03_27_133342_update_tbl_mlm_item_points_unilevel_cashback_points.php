<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMlmItemPointsUnilevelCashbackPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_mlm_item_points', function (Blueprint $table)
        {
            if (!Schema::hasColumn('tbl_mlm_item_points', 'UNILEVEL_CASHBACK_POINTS'))
            {
                $table->double('UNILEVEL_CASHBACK_POINTS')->default(0);
            }
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
