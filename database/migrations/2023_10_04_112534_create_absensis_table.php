<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_department");
            $table->foreignId("id_training");
            $table->foreignId("id_user");
            $table->string("status_absen", 50);
            $table->date('tanggal_absen');
            $table->timestamps();
            $table->foreign('id_department')->references('id')->on('departement')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_training')->references('id')->on('training')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
}
