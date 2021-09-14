<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetensidasarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensidasar', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); 
            $table->string('kode')->nullable(); //3.1 untuk pengetahuan dan 4.1 untuk ketrampilan
            $table->string('tapel_nama')->nullable(); 
            $table->string('kelas_nama')->nullable(); 
            $table->string('pelajaran_nama')->nullable(); 
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
        Schema::dropIfExists('kompetensidasar');
    }
}
