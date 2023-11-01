<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeleksiMahasiswaBarusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleksi_mahasiswa_barus', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->integer('daya_tampung')->default(0);
            $table->integer('mahasiswa_mendaftar')->default(0);
            $table->integer('mahasiswa_lulus_seleksi')->default(0);
            $table->integer('mahasiswa_baru_reguler')->default(0);
            $table->integer('mahasiswa_baru_transfer')->default(0);
            $table->integer('mahasiswa_aktif_reguler')->default(0);
            $table->integer('mahasiswa_aktif_transfer')->default(0);
            $table->integer('mahasiswa_aktif_luar_provinsi')->default(0);
            $table->integer('mahasiswa_aktif_luar_negeri')->default(0);
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
        Schema::dropIfExists('seleksi_mahasiswa_barus');
    }
}
