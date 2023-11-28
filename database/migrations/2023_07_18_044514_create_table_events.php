<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default(null);
            $table->date('date')->nullable()->default(null);
            $table->longText('detail')->nullable()->default(null);
            $table->tinyInteger('is_year_loop')->nullable()->default(1);

            $table->unsignedBigInteger('family_tree_id')->nullable()->default(null);
            $table->foreign('family_tree_id')->references('id')->on('family_trees')->onDelete('SET NULL');

            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');

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
        Schema::dropIfExists('events');
    }
}
