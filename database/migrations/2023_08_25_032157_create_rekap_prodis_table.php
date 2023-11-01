<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_prodis', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_prodi');
            $table->integer('fakultas');
            $table->string('jenjang');
            $table->enum('status', ['aktif', 'nonaktif', 'cuti', 'bidikmisi', 'asing', 'lulus', 'baru']);
            $table->integer('tahun');
            $table->integer('semester');
            $table->integer('pria');
            $table->integer('wanita');
            $table->integer('jumlah');
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
        Schema::dropIfExists('rekap_prodis');
    }
}
