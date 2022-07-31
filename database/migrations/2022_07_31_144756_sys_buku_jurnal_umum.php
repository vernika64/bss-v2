<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysBukuJurnalUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_buku_jurnal_umum', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_transaksi_akuntansi');
            $table->date('tgl_pencatatan_jurnal');
            $table->string('nama_transaksi');
            $table->string('nominal_transaksi');
            $table->string('deskripsi')->nullable();
            $table->enum('status_transaksi', ['open', 'closed']);
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
        Schema::dropIfExists('sys_buku_jurnal_umum');
    }
}
