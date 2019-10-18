<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->char('kd_jurusan',5)->primary();
            $table->unsignedBigInteger('id_fakultas');
            $table->string('nama');
            $table->char('nip_kajur',18);
            $table->string('nm_kajur',50);
            $table->timestamps();

            $table->foreign('id_fakultas')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
