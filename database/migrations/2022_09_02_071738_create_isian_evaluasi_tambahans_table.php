<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsianEvaluasiTambahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isian_evaluasi_tambahans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subpengaturan_id');
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->integer('verifikasi');
            $table->string('judul');
            $table->string('tanggal')->nullable();
            $table->string('komentar')->nullable();
            $table->string('dokumen1')->nullable();
            $table->string('dokumen2')->nullable();
            $table->string('dokumen3')->nullable();
            $table->string('dokumen4')->nullable();
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
        Schema::dropIfExists('isian_evaluasi_tambahans');
    }
}
