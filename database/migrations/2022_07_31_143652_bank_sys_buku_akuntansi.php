<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankSysBukuAkuntansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_buku_akuntansi', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kd_master_buku');
            $table->integer('kd_sub_master_buku');
            $table->integer('kd_bank');
            $table->string('nama_buku');
            $table->string('nominal');
            $table->integer('kd_admin');
            $table->timestamps();
            $table->unique(['kd_master_buku', 'kd_sub_master_buku', 'kd_bank'], 'index_buku_akuntansi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_buku_akuntansi');
    }
}
