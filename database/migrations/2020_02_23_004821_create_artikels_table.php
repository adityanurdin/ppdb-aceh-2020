<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('kode_artikel')->nullable();
            $table->string('kode_user')->nullable();
            $table->text('judul_artikel')->nullable();
            $table->text('deskripsi_artikel')->nullable();
            $table->text('slug_artikel')->nullable();
            $table->text('thumbnail_artikel')->nullable();
            $table->string('status_artikel')->nullable();
            $table->text('isi_artikel')->nullable();
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
        Schema::dropIfExists('artikels');
    }
}
