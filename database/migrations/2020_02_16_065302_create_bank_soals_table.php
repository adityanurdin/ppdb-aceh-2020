<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('uuid_madrasah');
            $table->string('uuid_operator');
            $table->string('kode_soal');
            $table->string('status_bank_soal');
            $table->string('crash_session');
            $table->string('timer_cat');
            $table->timestamp('tgl_bank_soal');
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
        Schema::dropIfExists('bank_soals');
    }
}
