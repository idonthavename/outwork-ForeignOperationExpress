<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system_order_no',50);
            $table->unsignedInteger('category_one');
            $table->unsignedInteger('category_two');
            $table->string('detail',100);
            $table->string('brand',100);
            $table->decimal('price');
            $table->string('catname',50);
            //$table->string('spec_unit',20);
            $table->unsignedMediumInteger('amount');
            //$table->unsignedTinyInteger('is_suit');
            $table->string('remark',100)->nullable();
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
        Schema::dropIfExists('order_product');
    }
}
