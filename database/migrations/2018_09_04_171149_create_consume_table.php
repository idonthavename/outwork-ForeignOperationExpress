<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consume', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable();
            $table->string('name',50);
            $table->string('consume_order_no',50)->unique();
            $table->string('system_order_no',50)->nullable();
            $table->string('user_order_no',50)->nullable();
            $table->unsignedTinyInteger('type')->default('1')->comment('1:支付  2:补扣  3:退款');
            $table->decimal('money')->default('0.00');
            $table->string('unionaccount',50)->nullable();
            $table->string('payaccount',50)->nullable();
            $table->string('remark',255)->nullable();
            $table->unsignedTinyInteger('handle')->default('0');
            $table->unsignedTinyInteger('status')->default('0');
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
        Schema::dropIfExists('consume');
    }
}
