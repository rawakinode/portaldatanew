<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_prodi');
            $table->string('kode');
            $table->string('nama');
            $table->integer('semester');
            $table->integer('sks');
            $table->integer('sks_praktikum')->default(0);
            $table->integer('sks_seminar')->default(0);
            $table->string('jenis')->nullable();
            $table->boolean('status')->default(null)->nullable();
            $table->boolean('capaian_sikap')->default(null)->nullable();
            $table->boolean('capaian_pengetahuan')->default(null)->nullable();
            $table->boolean('capaian_keterampilan_umum')->default(null)->nullable();
            $table->boolean('capaian_keterampilan_khusus')->default(null)->nullable();
            $table->string('jenis_dokumen')->nullable();
            $table->string('unit_penyelenggara')->nullable();
            $table->float('konversi', 3,2)->nullable();
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
        Schema::dropIfExists('mata_kuliahs');
    }
}
