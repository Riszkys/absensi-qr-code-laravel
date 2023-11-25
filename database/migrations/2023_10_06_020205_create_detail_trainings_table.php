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
            $table->integer("id_user");
            $table->integer("id_training");
            $table->integer("id_departement");
            $table->string("id_absen");
            $table->string("nama_training");
            $table->string("waktu_mulai");
            $table->string("tanggal_training");
            $table->string("lokasi_training");
            $table->string("pic");
            $table->string("status");
            $table->string("status_training");
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
        Schema::dropIfExists('detail_trainings');
    }
}
