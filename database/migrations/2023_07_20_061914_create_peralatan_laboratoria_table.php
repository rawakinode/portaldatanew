<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeralatanLaboratoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peralatan_laboratoria', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('nama');
            $table->string('lokasi');
            $table->string('fungsi');
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
        Schema::dropIfExists('peralatan_laboratoria');
    }
}
