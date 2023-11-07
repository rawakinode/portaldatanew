<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalMahasiswaAktifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_mahasiswa_aktifs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prodi');
            $table->integer('fakultas');
            $table->string('jenjang');
            $table->integer('tahun');
            $table->integer('semester');
            $table->integer('total');
            $table->enum('status', ['aktif', 'nonaktif', 'cuti']);
            $table->json('jalur_masuk');
            $table->json('tahun_masuk');
            $table->json('jenis_kelamin');
            $table->json('ipk');

            
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
        Schema::dropIfExists('portal_mahasiswa_aktifs');
    }
}
