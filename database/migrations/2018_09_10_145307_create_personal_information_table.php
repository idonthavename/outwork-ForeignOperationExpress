<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid');
            $table->string('sender_xing',100);
            $table->string('sender_ming',100);
            $table->string('sender_city',50);
            $table->string('sender_area',50);
            $table->string('sender_paperType',10);
            $table->string('sender_paperNo',100);
            $table->string('sender_quitAddress',255);
            $table->string('sender_quitCode',20);
            $table->string('sender_phone',20);
            $table->string('sender_fixedPhone',20)->nullable();

            $table->string('receive_country',20);
            $table->string('receive_name',20);
            $table->string('receive_address',255);
            $table->string('receive_code',20);
            $table->string('receive_phone',20);
            $table->string('receive_fixedPhone',20)->nullable();
            $table->string('receive_wq',20)->nullable();

            $table->string('sfz',200);
            $table->string('xyk',200)->nullable();
            $table->string('sdm',200)->nullable();
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
        Schema::dropIfExists('personal_information');
    }
}
