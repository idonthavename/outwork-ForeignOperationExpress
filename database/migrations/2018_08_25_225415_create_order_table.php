<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid');
            $table->string('system_order_no',50)->unique();
            $table->string('user_order_no',50)->nullable();
            $table->string('express_no',50)->nullable();
            $table->unsignedInteger('line_id');
            $table->string('s_name',100);
            $table->string('s_phone',20);
            $table->string('s_code',20);
            $table->string('s_address',255);
            $table->string('s_country',50);
            $table->string('s_province',50);
            $table->string('s_city',50);
            $table->string('r_name',20);
            $table->string('r_phone',20);
            $table->unsignedTinyInteger('r_cre_type');
            $table->string('r_cre_num',20);
            $table->string('r_code',20)->nullable();
            $table->string('r_province',50)->nullable();
            $table->string('r_city',50)->nullable();
            $table->string('r_town',50)->nullable();
            $table->string('r_addressDetail',255);
            $table->unsignedTinyInteger('upload_type')->default('0');
            $table->string('id_card_front',200)->nullable();
            $table->string('id_card_back',200)->nullable();
            $table->string('depot',100);
            $table->text('addons')->nullable();
            $table->unsignedInteger('linetwo')->default('0')->comment('关联的二级线路');
            $table->unsignedDecimal('weight')->default('0.00')->comment('真实称重值');
            $table->decimal('tax')->default('0.00')->comment('税金');
            $table->decimal('money')->default('0.00')->comment('首重+附加服务费用');
            $table->unsignedTinyInteger('status')->default('0')->comment('当前状态');
            $table->unsignedTinyInteger('before_status')->default('0')->comment('上一个状态');
            $table->unsignedTinyInteger('user_confirm')->default('0')->comment('异常件用户是否点击确认');
            $table->string('fail_reason',255)->nullable()->comment('异常原因');
            $table->string('productdetail',500)->nullable()->comment('物品内容');
            $table->string('productremark',500)->nullable()->comment('物品备注');
            $table->decimal('deduct_money')->default('0.00')->comment('手动导入扣款金额');
            $table->unsignedTinyInteger('print')->default('0');
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
        Schema::dropIfExists('order');
    }
}
