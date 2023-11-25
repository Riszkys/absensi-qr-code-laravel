<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_training');
            $table->integer('id_test');
            $table->boolean('pre_test');
            $table->boolean('post_test');
            $table->boolean('evaluasi');
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
        Schema::dropIfExists('history_tests');
    }
}