<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hkis', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->string('judul');
            $table->string('keterangan')->nullable();
            $table->string('bukti')->nullable();
            $table->string('nidn')->nullable();
            $table->string('nim')->nullable();
            $table->integer('tahun');
            $table->string('nomor');
            $table->enum('jenis', ['paten', 'paten sederhana', 'merek', 'desain industri', 'hak cipta', 'indikasi geografis', 'perlindungan varietas tanaman', 'desain tata letak sirkuit terpadu', 'teknologi tepat guna', 'produk', 'karya seni', 'rekayasa sosial']);
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
        Schema::dropIfExists('hkis');
    }
}
