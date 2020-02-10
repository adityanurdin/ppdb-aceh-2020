<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('uuid_pembukaan');
            $table->string('uuid_peserta');
            $table->string('kode_pendaftaran');
            $table->integer('nomor_pendaftaran');
            $table->string('status_diterima');
            $table->string('jalur_diterima');
            $table->text('url_transfer');
            $table->string('status_transfer');
            $table->timestamp('tgl_pendaftaran');
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
        Schema::dropIfExists('pendaftarans');
    }
}
