<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracerStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('nim');
            $table->integer('masa_studi');
            $table->integer('waktu_tunggu_kerja');
            $table->enum('kesesuaian_bidang_ilmu', ['sesuai', 'kurang sesuai', 'tidak sesuai']);
            $table->enum('tingkat', ['lokal / wilayah / berwirausaha tidak berbadan hukum', 'nasional / berwirausaha berbadan hukum', 'multinasional / internasional','melanjutkan studi']);
            $table->decimal('penghasilan', 30, 0);
            $table->boolean('umr');
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
        Schema::dropIfExists('tracer_studies');
    }
}
