<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();

            $table->string('cccd_image_before')->nullable()->default(null);
            $table->string('cccd_image_after')->nullable()->default(null);

            $table->longText('story')->nullable()->default(null);
            $table->string('job')->nullable()->default(null);
            $table->string('position')->nullable()->default(null);
            $table->string('organization')->nullable()->default(null);
            $table->text('cert_images')->nullable()->default(null);

            $table->integer('leave_year')->nullable()->default(null);
            $table->integer('leave_month')->nullable()->default(null);
            $table->integer('leave_day')->nullable()->default(null);
            $table->string('rest_place')->nullable()->default(null);
            $table->string('lat')->nullable()->default(null);
            $table->string('long')->nullable()->default(null);
            $table->text('rest_images')->nullable()->default(null);

            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('user_infos');
    }
}
