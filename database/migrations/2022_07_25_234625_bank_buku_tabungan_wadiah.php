<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankBukuTabunganWadiah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_buku_tabungan_wadiah', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kd_produk_tabungan');
            $table->string('kd_buku_tabungan');
            $table->integer('kd_cif');
            $table->integer('kd_bank');
            $table->bigInteger('total_nilai')->nullable();
            $table->integer('kd_admin');
            $table->timestamps();
            $table->unique(['kd_produk_tabungan', 'kd_cif', 'kd_buku_tabungan'], 'index_tabungan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_buku_tabungan_wadiah');
    }
}
