<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid');
            $table->string('yuansferId',50)->unique()->nullable();
            $table->string('charge_order_no',50)->unique();
            $table->string('type',20)->comment('支持"alipay”,“wechatpay”,“unionpay"，即支付宝，微信，银联');
            $table->decimal('money')->default('0.00');
            $table->string('currency',10);
            $table->string('terminal',10);
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
        Schema::dropIfExists('charge');
    }
}
