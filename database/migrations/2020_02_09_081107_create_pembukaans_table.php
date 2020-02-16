<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembukaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembukaans', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('uuid_madrasah');
            $table->string('uuid_operator');
            $table->date('tgl_pembukaan');
            $table->date('tgl_penutupan');
            $table->date('tgl_pengumuman');
            $table->text('url_brosur');
            $table->string('tahun_akademik');
            $table->string('status_nomor');
            $table->timestamp('tgl_post');
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
        Schema::dropIfExists('pembukaans');
    }
}
