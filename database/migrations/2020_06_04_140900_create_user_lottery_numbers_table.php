<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLotteryNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lottery_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lottery_number');
            $table->integer('user_id');
            $table->tinyInteger('is_taken_out')->default('0');
            // $table->tinyInteger('is_winner_status');
            $table->softDeletes();
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
        Schema::dropIfExists('user_lottery_numbers');
    }
}
