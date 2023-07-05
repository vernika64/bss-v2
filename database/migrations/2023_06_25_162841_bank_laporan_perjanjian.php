<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankLaporanPerjanjian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_laporan_perjanjian', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_laporan');
            $table->string('no_laporan');
            $table->string('judul_laporan')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('kd_karyawan');
            $table->string('kd_bank');
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
        //
    }
}
