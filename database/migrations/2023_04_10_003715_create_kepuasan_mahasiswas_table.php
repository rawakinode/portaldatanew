<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepuasanMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepuasan_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('nim');
            $table->enum('keandalan', ['sangat baik', 'baik', 'cukup', 'kurang']);
            $table->enum('daya_tanggap', ['sangat baik', 'baik', 'cukup', 'kurang']);
            $table->enum('kepastian', ['sangat baik', 'baik', 'cukup', 'kurang']);
            $table->enum('empati', ['sangat baik', 'baik', 'cukup', 'kurang']);
            $table->enum('nyata', ['sangat baik', 'baik', 'cukup', 'kurang']);
            $table->string('tindak_lanjut');
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
        Schema::dropIfExists('kepuasan_mahasiswas');
    }
}
