<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','50');
            $table->string('channel','50');
            $table->string('content',500)->nullable();
            $table->unsignedTinyInteger('iupid')->default('0');
            $table->text('linetwo')->nullable();
            $table->text('products')->nullable();
            $table->decimal('ykg')->default('0.00')->comment('首重');
            $table->text('price')->nullable()->comment('单价');
            $table->text('overweight')->nullable()->comment('超重');
            $table->string('unit',10)->nullable()->comment('单位');
            $table->unsignedTinyInteger('order')->default('0');
            $table->string('remark','255')->nullable();
            $table->unsignedTinyInteger('isban')->default('0');
            $table->unsignedTinyInteger('rule')->default('0');
            $table->decimal('goon')->default('0.00')->comment('续重');
            $table->decimal('outon')->default('0.00')->comment('退位');
            $table->unsignedTinyInteger('print_template')->default('0');
            $table->unsignedTinyInteger('file_template')->default('0');
            $table->string('ordersExcel',200)->nullable();
            $table->string('onlineExcel',200)->nullable();
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
        Schema::dropIfExists('line');
    }
}
