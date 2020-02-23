<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('kode_video');
            $table->string('kode_user');
            $table->text('judul_video')->nullable();
            $table->text('deskripsi_video')->nullable();
            $table->text('slug_video')->nullable();
            $table->text('url_video')->nullable();
            $table->text('thumbnail_video')->nullable();
            $table->string('status_video')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
