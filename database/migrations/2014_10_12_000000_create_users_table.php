<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('type',10);
            $table->string('mobile')->nullable();
            $table->string('xing', 100);
            $table->string('ming', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedTinyInteger('active')->default('0');
            $table->unsignedTinyInteger('step')->default('2');
            $table->char('user_identification',8)->unique();
            $table->unsignedTinyInteger('rank')->default('1');
            $table->decimal('money')->default('0.00');
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
        Schema::dropIfExists('users');
    }
}
