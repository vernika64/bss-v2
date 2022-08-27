<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysMasterBukuAkuntansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_master_buku_akuntansi', function(Blueprint $table) {
            $table->id();
            $table->integer('kd_master_buku');
            $table->integer('kd_sub_master_buku');
            $table->string('nama_buku');
            $table->integer('kd_admin');
            $table->timestamps();
            $table->index(['kd_master_buku', 'kd_sub_master_buku'], 'index_akun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_master_buku_akuntansi');
    }
}
