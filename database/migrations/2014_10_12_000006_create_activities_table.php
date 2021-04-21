<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->timestamp('start_time', $precision = 0)->nullable();
            $table->timestamp('end_time', $precision = 0)->nullable();
            $table->text('comment');
            $table->bigInteger('id_assignments')->unsigned();
            $table->timestamps();
            $table->foreign('id_assignments')->references('id')->on('assignments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
