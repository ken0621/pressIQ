<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblSentEmailPressRelease extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sent_email_press_release', function (Blueprint $table) {
            $table->increments('email_id');
            $table->string('email_content');
            $table->string('email_title');
            $table->string('email_subject');
            $table->string('to');
            $table->string('from');
            $table->string('email_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('create_tbl_sent_email_press_release');
    }
}
