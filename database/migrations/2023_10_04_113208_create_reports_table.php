<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_peserta");
            $table->foreignId("id_training");
            $table->String("feedback");
            $table->timestamps();
            $table->foreign('id_peserta')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_training')->references('id')->on('training')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
