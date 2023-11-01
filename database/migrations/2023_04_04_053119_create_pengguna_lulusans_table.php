<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaLulusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna_lulusans', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('nim');
            $table->string('nama_penilai');
            $table->string('jabatan_penilai');
            $table->string('instansi');
            $table->enum('etika', ['sangat baik','baik','cukup','kurang']);
            $table->enum('kompetensi_utama', ['sangat baik','baik','cukup','kurang']);
            $table->enum('bahasa_asing', ['sangat baik','baik','cukup','kurang']);
            $table->enum('teknologi_informasi', ['sangat baik','baik','cukup','kurang']);
            $table->enum('komunikasi', ['sangat baik','baik','cukup','kurang']);
            $table->enum('kerjasama', ['sangat baik','baik','cukup','kurang']);
            $table->enum('pengembangan_diri', ['sangat baik','baik','cukup','kurang']);
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
        Schema::dropIfExists('pengguna_lulusans');
    }
}
