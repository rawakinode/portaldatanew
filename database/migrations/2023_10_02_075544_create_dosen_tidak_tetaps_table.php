<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTidakTetapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_tidak_tetaps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kode');
            $table->string('nidn');
            $table->string('nama');
            $table->boolean('kelamin');
            $table->integer('pendidikan');
            $table->string('bidang_keahlian')->nullable();
            $table->string('pascasarjana')->nullable();
            $table->string('nomor_sertifikasi')->nullable();
            $table->string('nomor_sertifikasi_profesi_industri')->nullable();
            $table->string('golongan')->nullable();
            $table->integer('fungsional')->nullable();
            $table->string('matakuliah_prodi')->nullable();
            $table->string('matakuliah_prodi_lain')->nullable();
            $table->boolean('kesesuaian_matakuliah')->default(true);
            $table->enum('industri_praktisi', ['industri', 'praktisi'])->nullable();
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
        Schema::dropIfExists('dosen_tidak_tetaps');
    }
}
