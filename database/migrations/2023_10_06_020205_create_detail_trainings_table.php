<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_user");
            $table->foreignId("id_training");
            $table->foreignId("id_departement");
            $table->foreignId("id_absen");
            $table->string("nama_training");
            $table->string("waktu_mulai");
            $table->string("tanggal_training");
            $table->string("lokasi_training");
            $table->string("pic");
            $table->string("status");
            $table->string("status_training");
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_training')->references('id')->on('training')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_departement')->references('id')->on('departement')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_absen')->references('id')->on('absensi')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_trainings');
    }
}
