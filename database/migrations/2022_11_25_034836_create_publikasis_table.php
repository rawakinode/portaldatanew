<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publikasis', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('judul');
            $table->string('penulis_nidn')->nullable();
            $table->string('penulis_dosen');
            $table->json('anggota')->nullable();
            $table->enum('jenis',[ 
                'jurnal',
                'seminar',
                'media massa',
                'pagelaran pameran presentasi'
            ]);
            $table->enum('sub_jenis',[ 
                'nasional tidak terakreditasi',
                'nasional terakreditasi',
                'internasional',
                'internasional bereputasi',
                'wilayah / lokal / PT',
                'nasional',
            ]);
            $table->string('publikasi');
            $table->integer('sitasi');
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
        Schema::dropIfExists('publikasis');
    }
}
