<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTetapProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_tetap_prodis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kode');
            $table->string('nidn');
            $table->boolean('kesesuaian_kompetensi');
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
        Schema::dropIfExists('dosen_tetap_prodis');
    }
}
