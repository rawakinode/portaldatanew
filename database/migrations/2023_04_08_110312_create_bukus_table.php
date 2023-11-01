<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('penerbit');
            $table->enum('kategori', ['buku ajar', 'buku referensi', 'buku monograf', 'lainnya']);
            $table->string('kota');
            $table->string('nim')->nullable();
            $table->string('nidn')->nullable();
            $table->string('isbn');
            $table->string('keterangan')->nullable();
            $table->string('bukti')->nullable();
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
        Schema::dropIfExists('bukus');
    }
}
