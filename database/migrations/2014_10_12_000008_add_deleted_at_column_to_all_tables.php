<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtColumnToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users_assignments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users_roles', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('users_assignments', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
