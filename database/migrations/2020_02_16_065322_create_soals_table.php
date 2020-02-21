<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('uuid_operator')->nullable();
            $table->string('kode_soal')->nullable();
            $table->string('jenis_soal')->nullable();
            $table->integer('nomor_soal')->nullable();
            $table->text('soal')->nullable();
            $table->string('gambar')->nullable();
            $table->string('a')->nullable();
            $table->string('b')->nullable();
            $table->string('c')->nullable();
            $table->string('d')->nullable();
            $table->string('kunci_jawaban')->nullable();
            $table->timestamp('tgl_soal')->nullable();
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
        Schema::dropIfExists('soals');
    }
}
