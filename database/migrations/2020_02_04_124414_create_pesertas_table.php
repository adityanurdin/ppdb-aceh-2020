<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('nama')->nullable();
            $table->string('NIK')->unique()->nullable();
            $table->string('nisn')->nullable();
            $table->string('tmp')->nullable();
            $table->date('tgl')->nullable();
            $table->string('jkl')->nullable();
            $table->string('agama')->nullable();
            $table->string('hobi')->nullable();
            $table->string('cita2')->nullable();
            $table->string('anak_ke')->nullable();
            $table->string('jml_saudara')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->string('npsn_sekolah_asal')->nullable();
            $table->string('nama_sekolah_asal')->nullable();
            $table->string('alamat_sekolah_asal')->nullable();
            $table->text('jenis_prestasi')->nullable();
            $table->string('yatim_piatu')->nullable();
            $table->string('kartu_program')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tmp_ayah')->nullable();
            $table->date('tgl_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tmp_ibu')->nullable();
            $table->date('tgl_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->dateTime('tgl_registrasi')->nullable();
            $table->string('kontak_peserta')->nullable();
            $table->string('email')->nullable();
            $table->enum('status_aktif' , ['yes' , 'no'])->nullable();
            $table->text('pas_foto')->nullable();
            $table->text('akte')->nullable();
            $table->text('kk')->nullable();
            $table->text('rapot_1')->nullable();
            $table->text('rapot_2')->nullable();
            $table->text('rapot_3')->nullable();
            $table->text('rapot_4')->nullable();
            $table->text('rapot_5')->nullable();
            $table->text('rapot_6')->nullable();
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
}
