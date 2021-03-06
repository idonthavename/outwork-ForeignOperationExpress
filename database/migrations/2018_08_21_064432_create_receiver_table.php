<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiver', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid');
            $table->string('name',20);
            $table->string('phone',20);
            $table->unsignedTinyInteger('cre_type')->default(1);
            $table->string('cre_num',50);
            $table->string('province',20);
            $table->string('city',20);
            $table->string('town',20);
            $table->string('addressDetail',200);
            $table->string('code',20);
            $table->string('tag',100)->nullable();
            $table->unsignedInteger('line_id')->default(0);
            $table->string('id_card_front',200)->nullable();
            $table->string('id_card_back',200)->nullable();
            $table->unsignedTinyInteger('isdefault')->default(0);
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
        Schema::dropIfExists('receiver');
    }
}
