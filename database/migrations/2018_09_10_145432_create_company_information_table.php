<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid');

            $table->string('company_city',50);
            $table->string('company_area',50);
            $table->string('company_name',50);
            $table->string('company_address',255);
            $table->string('company_delegate',20);

            $table->string('company_yy',100);
            $table->string('company_sh',100);
            $table->string('company_quitAddress',255);
            $table->string('company_quitCode',20);

            $table->string('company_contact',20);
            $table->string('company_phone',20);
            $table->string('company_fixedPhone',20)->nullable();
            $table->string('company_wq',20)->nullable();

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
        Schema::dropIfExists('company_information');
    }
}
