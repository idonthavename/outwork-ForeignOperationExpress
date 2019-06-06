<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('type')->default('0')->comment('1产品服务 2收费说明 3首页banner 4合作伙伴 5公告');
            $table->string('title',50)->nullable();
            $table->text('content')->nullable();
            $table->string('thumb',200)->nullable();
            $table->string('link',200)->nullable();
            $table->unsignedTinyInteger('order')->default('0');
            $table->unsignedTinyInteger('isban')->default('0');
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
        Schema::dropIfExists('content');
    }
}
