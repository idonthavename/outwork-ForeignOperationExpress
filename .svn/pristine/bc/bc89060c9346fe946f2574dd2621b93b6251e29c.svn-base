<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestfulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('restful')) {
            Schema::table('restful', function (Blueprint $table) {
                $table->increments('id');
                $table->string('appkey',50);
                $table->char('secret',50);
                $table->unsignedTinyInteger('ban')->default('0');
                $table->timestamps();
            });
        }else{
            Schema::create('restful', function (Blueprint $table) {
                $table->increments('id');
                $table->string('appkey',50);
                $table->char('secret',50);
                $table->unsignedTinyInteger('ban')->default('0');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restful', function (Blueprint $table) {
            Schema::dropIfExists('restful');
        });
    }
}
