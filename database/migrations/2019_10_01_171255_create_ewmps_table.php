<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEwmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ewmps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_ta');
            $table->char('nidn',9);
            $table->integer('ps_intra')->default(0);
            $table->integer('ps_lain')->default(0);
            $table->integer('ps_luar')->default(0);
            $table->integer('penelitian')->default(0);
            $table->integer('pkm')->default(0);
            $table->integer('tugas_tambahan')->default(0);
            $table->timestamps();

            $table->unique(['id_ta','nidn']);
            $table->foreign('id_ta')->references('id')->on('academic_years')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nidn')->references('nidn')->on('teachers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ewmps');
    }
}
