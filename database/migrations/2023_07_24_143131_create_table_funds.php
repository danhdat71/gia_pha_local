<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFunds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->date('date')->nullable()->default(null);
            $table->tinyInteger('fund_type')->comment('1: collect, 2: spend');
            $table->tinyInteger('status')->comment('0: confirm, 1: ok');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->unsignedBigInteger('event_id')->nullable()->default(null);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('SET NULL');
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
        Schema::dropIfExists('funds');
    }
}
