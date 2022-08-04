<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysProdukTabungan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_produk_tabungan', function(Blueprint $table) {
            $table->id();
            $table->string('kd_produk');
            $table->string('nama_produk');
            $table->text('keterangan');
            $table->integer('kd_admin');
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
        Schema::dropIfExists('sys_produk_tabungan');
    }
}
