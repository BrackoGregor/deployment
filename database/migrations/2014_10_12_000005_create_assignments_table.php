<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('work_description', 200);
            $table->string('developer_description', 200);
            $table->bigInteger('id_clients')->unsigned();
            $table->bigInteger('id_statuses')->unsigned();
            $table->foreign('id_clients')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_statuses')->references('id')->on('statuses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('assignments');
    }
}
