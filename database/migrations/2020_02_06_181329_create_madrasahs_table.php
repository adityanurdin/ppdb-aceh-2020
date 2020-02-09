<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMadrasahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('madrasahs', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('kode_satker')->unique()->nullable();
            $table->string('nsm')->nullable();
            $table->string('npsn')->nullable()->unique();
            $table->string('status');
            $table->string('jenjang');
            $table->string('nama_madrasah')->unique();
            $table->text('alamat')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('email_madrasah')->nullable();
            $table->string('kontak_madrasah')->nullable();
            $table->string('akreditasi')->nullable();
            $table->text('logo_madrasah')->nullable();
            $table->text('preview')->nullable();
            $table->text('persyaratan')->nullable();
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
        Schema::dropIfExists('madrasahs');
    }
}
