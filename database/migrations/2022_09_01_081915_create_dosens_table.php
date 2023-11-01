<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kode');
            $table->string('nidn')->unique();
            $table->string('nama');
            $table->boolean('kelamin');
            $table->integer('pendidikan');
            $table->string('bidang_keahlian');
            $table->boolean('kesesuaian_kompetensi');
            $table->string('pendidikan_magister')->nullable();
            $table->string('pendidikan_doctoral')->nullable();
            $table->enum('statusdosen',[ 
                'tetap',
                'tidak tetap',
                'industri praktisi'
            ]);
            $table->string('perusahaan_industri')->nullable();
            $table->string('nomor_sertifikasi')->nullable();
            $table->string('nomor_sertifikasi_profesi_industri')->nullable();
            $table->string('golongan')->nullable();
            $table->integer('fungsional')->nullable();
            $table->string('upload')->nullable();
            $table->string('matakuliah_prodi')->nullable();
            $table->boolean('kesesuaian_matakuliah');
            $table->string('matakuliah_prodi_lain')->nullable();
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
        Schema::dropIfExists('dosens');
    }
}
