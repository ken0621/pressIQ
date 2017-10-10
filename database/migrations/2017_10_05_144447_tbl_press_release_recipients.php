<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblPressReleaseRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tbl_press_release_recipients', function (Blueprint $table) {
            $table->increments('recipient_id');
            $table->string('recipient_email_address');
            $table->string('recipient_name');
            $table->string('recipient_position');
            $table->string('group_name');
            $table->timestamp('created_at');
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
