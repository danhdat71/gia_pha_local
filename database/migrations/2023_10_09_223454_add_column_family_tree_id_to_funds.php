<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFamilyTreeIdToFunds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->unsignedBigInteger('family_tree_id')->nullable()->default(null)->after('user_id');
            $table->foreign('family_tree_id')->references('id')->on('family_trees')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->dropForeign(['family_tree_id']);
            $table->dropColumn(['family_tree_id']);
        });
    }
}
