<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinetwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linetwo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','50');
            $table->decimal('money')->default('0.00');
            $table->unsignedTinyInteger('print_template')->default('0');
            $table->unsignedTinyInteger('order')->default('0');
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
        Schema::dropIfExists('linetwo');
    }
}
