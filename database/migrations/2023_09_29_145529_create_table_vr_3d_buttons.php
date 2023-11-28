<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVr3dButtons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vr_3d_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default(null);
            $table->double('button_x')->nullable()->default(0);
            $table->double('button_y')->nullable()->default(0);
            $table->double('button_z')->nullable()->default(0);
            $table->unsignedBigInteger('vr_3d_id')->nullable()->default(null);
            $table->foreign('vr_3d_id')->references('id')->on('vr_3ds')->onDelete('CASCADE');
            $table->unsignedBigInteger('to_vr_3d_id')->nullable()->default(null);
            $table->foreign('to_vr_3d_id')->references('id')->on('vr_3ds')->onDelete('CASCADE');
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
        Schema::dropIfExists('vr_3d_buttons');
    }
}
