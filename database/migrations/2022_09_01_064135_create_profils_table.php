<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('kode')->unique();
            $table->integer('akreditasi')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('berlaku_start')->nullable();
            $table->date('berlaku_end')->nullable();
            $table->integer('nilai')->nullable();
            $table->string('sk_akreditasi')->nullable();
            $table->string('lembaga')->nullable();
            $table->integer('akreditasi_internasional')->nullable();
            $table->date('berlaku_internasional')->nullable();
            $table->string('sk_akreditasi_internasional')->nullable();
            $table->string('lembaga_internasional')->nullable();
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
        Schema::dropIfExists('profils');
    }
}
