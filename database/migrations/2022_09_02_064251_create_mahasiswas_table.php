<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kode_prodi');
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->integer('kelamin');
            $table->enum('jalur_masuk', ['snmptn', 'sbmptn', 'smmptn', 'lainnya'])->nullable();
            $table->integer('tahun_masuk');
            $table->boolean('bidikmisi')->default(false);
            $table->boolean('asing')->default(false);
            $table->boolean('asing_part_time')->nullable();
            $table->decimal('ipk', 4, 2)->nullable();
            $table->integer('masastudi')->nullable();
            $table->integer('daftar_ulang')->nullable();
            $table->integer('tahun_keluar')->nullable();
            $table->string('status_keluar')->nullable();
            $table->date('tanggal_yudisium')->nullable();
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
        Schema::dropIfExists('mahasiswas');
    }
}
