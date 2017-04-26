<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMlmStairstepSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_mlm_stairstep_settings', function (Blueprint $table) {
            //
            $table->integer("stairstep_break_away_level");
            $table->integer("stairstep_break_away_percent");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_mlm_stairstep_settings', function (Blueprint $table) {
            //
        });
    }
}
