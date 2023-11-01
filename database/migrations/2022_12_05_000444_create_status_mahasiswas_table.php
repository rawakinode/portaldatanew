<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->enum('semester', [1,2,3,4,5,6]);
            $table->foreignId('mahasiswa_id');
            $table->float('ipk', 3,2)->nullable();
            $table->integer('sks')->nullable();
            $table->enum('status', ['aktif','nonaktif','cuti'])->nullable();
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
        Schema::dropIfExists('status_mahasiswas');
    }
}
