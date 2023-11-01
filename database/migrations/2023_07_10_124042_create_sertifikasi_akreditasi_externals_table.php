<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasiAkreditasiExternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasi_akreditasi_externals', function (Blueprint $table) {
            $table->id();
            $table->string('lembaga');
            $table->integer('tahun_berakhir');
            $table->enum('jenis', ['akreditasi', 'sertifikasi']);
            $table->enum('lingkup', ['perguruan tinggi', 'fakultas', 'prodi']);
            $table->enum('tingkat', ['nasional', 'internasional']);
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('sertifikasi_akreditasi_externals');
    }
}
