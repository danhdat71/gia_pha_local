<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'created_at', 'updated_at']);
            $table->string('full_name');
            $table->string('cccd_number')->nullable()->default(null)->unique();
            $table->string('role_name')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->integer('born_year')->nullable()->default(null);
            $table->integer('born_month')->nullable()->default(null);
            $table->integer('born_day')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('domicile')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->tinyInteger('gender')->nullable()->default(null)->comment('1: male, 2: female');
            $table->tinyInteger('type')->nullable()->default(null)->comment('1: family-admin, 2: sub-family-admin, 3: secretary, 4: user-normal');
            $table->tinyInteger('is_main')->nullable()->default(null)->comment('1: is family member main, 0: is couple from other');

            // FamilyTreeJs Data
            $table->integer('position_index')->nullable()->default(null);
            $table->unsignedBigInteger('parent_marriage_id')->nullable()->default(null);
            $table->unsignedBigInteger('main_person_id')->nullable()->default(null);

            $table->unsignedBigInteger('family_tree_id')->nullable()->default(null)->comment('belong to group family tree');
            $table->foreign('family_tree_id')->references('id')->on('family_trees')->onDelete('SET NULL');
        });

        Schema::table('users', function (Blueprint $table) {
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['family_tree_id']);
            $table->string('name');
            $table->dropColumn([
                'role_name',
                'avatar',
                'birthday',
                'address',
                'domicile',
                'email',
                'phone',
                'gender',
                'parent_marriage_id',
                'main_person_id',
                'position_index',
                'family_tree_id',
                'created_at',
                'updated_at',
            ]);
        });
    }
}
