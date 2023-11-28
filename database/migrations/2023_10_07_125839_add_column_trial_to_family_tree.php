<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTrialToFamilyTree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_trees', function (Blueprint $table) {
            $table->tinyInteger('is_approve_trial')
                ->nullable()
                ->default(null)
                ->comment('0: trial, 1: active')
                ->after('description');
            $table->integer('max_member_trial')->nullable()->default(null)->after('description');
            $table->datetime('expired_at_trial')->nullable()->default(null)->after('description');
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
            $table->dropColumn(['is_approve_trial', 'max_member_trial', 'expired_at_trial']);
        });
    }
}
