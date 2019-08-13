<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coin');
            $table->string('small_name');
            $table->string('description');
            $table->integer('initial_amount');
            $table->boolean('available')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coin')->references('id')->on('coins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
