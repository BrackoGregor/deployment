<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertAssignmentStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('statuses')->insert(
            array(
                'name' => 'completed',
                'created_at' => Carbon::now("Europe/Rome"),
                'updated_at' => Carbon::now("Europe/Rome")
            )
        );

        DB::table('statuses')->insert(
            array(
                'name' => 'in progress',
                'created_at' => Carbon::now("Europe/Rome"),
                'updated_at' => Carbon::now("Europe/Rome")
            )
        );

        DB::table('statuses')->insert(
            array(
                'name' => 'waiting',
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
        Schema::table('statuses', function (Blueprint $table) {
            //
        });
    }
}
