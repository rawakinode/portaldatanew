<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubpengaturansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpengaturans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('urutan');
            $table->integer('tipe');
            $table->integer('pengaturan_id');
            $table->integer('role');
            $table->string('judul');
            $table->string('berkas');
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
        Schema::dropIfExists('subpengaturans');
    }
}
