<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerolehanDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perolehan_danas', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('judul');
            $table->enum('sumber',[ 
                'mahasiswa',
                'kementerian & yayasan',
                'perguruan tinggi',
                'sumber lain',
            ]);
            $table->enum('jenis',[ 
                'spp',
                'sumbangan lain',
                'anggaran rutin',
                'anggaran pembangunan',
                'hibah penelitian',
                'hibah pkm',
                'jasa layanan profesi dan keahlian',
                'produk institusi',
                'kerjasama kelembagaan',
                'hibah',
                'dana lestari dan filantropis',
                'lain-lain',
            ]);
            $table->decimal('jumlah', 20, 0);
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
        Schema::dropIfExists('perolehan_danas');
    }
}
