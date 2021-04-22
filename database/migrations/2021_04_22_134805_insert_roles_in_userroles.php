<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertRolesInUserroles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users_roles')->insert(
            array(
                'role' => 'user',
                'created_at' => Carbon::now("Europe/Rome"),
                'updated_at' => Carbon::now("Europe/Rome")
            )
        );

        DB::table('users_roles')->insert(
            array(
                'role' => 'admin',
                'created_at' => Carbon::now("Europe/Rome"),
                'updated_at' => Carbon::now("Europe/Rome")
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_roles', function (Blueprint $table) {
            //
        });
    }
}
