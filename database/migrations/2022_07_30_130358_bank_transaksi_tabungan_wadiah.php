<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankTransaksiTabunganWadiah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transaksi_tabungan_wadiah', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_transaksi_tabungan');
            $table->string('kd_buku_tabungan');
            $table->enum('jenis_transaksi', ['tarik', 'setor']);
            $table->string('no_nota_fisik');
            $table->bigInteger('nominal_transaksi');
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
        Schema::dropIfExists('bank_transaksi_tabungan_wadiah');
    }
}
