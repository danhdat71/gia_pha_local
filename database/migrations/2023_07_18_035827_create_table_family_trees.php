<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFamilyTrees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_trees', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default(null);
            $table->integer('template_id')->nullable(false)->default(1);
            $table->string('domain')->nullable(true)->default(null);
            $table->string('audio_link')->nullable(true)->default(null);
            $table->longtext('description')->nullable(true)->default(null);
            $table->unsignedBigInteger('root_admin_id')->nullable()->default(null)->comment('created by root admin');
            $table->foreign('root_admin_id')->references('id')->on('root_admins')->onDelete('SET NULL');
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
        Schema::table('family_trees', function (Blueprint $table) {
            Schema::dropIfExists('family_trees');
        });
    }
}
