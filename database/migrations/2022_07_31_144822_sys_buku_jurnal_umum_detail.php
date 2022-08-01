<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysBukuJurnalUmumDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_buku_jurnal_umum_detail', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_transaksi_akuntansi');
            $table->integer('kd_buku_akuntansi');
            $table->bigInteger('nominal_debit');
            $table->bigInteger('nominal_kredit');
            $table->string('deskripsi')->nullable();
            $table->integer('kd_admin');
            $table->integer('kd_bank');
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
        Schema::dropIfExists('sys_buku_jurnal_umum_detail');
    }
}
