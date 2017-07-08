<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblMlmSlotAddEonAccountNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_mlm_slot', function (Blueprint $table) {
            //
            $table->string('slot_eon_account_no')->nullable();
            $table->string('slot_eon_card_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_mlm_slot', function (Blueprint $table) {
            //
        });
    }
}
