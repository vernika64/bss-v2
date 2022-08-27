<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankBukuAkuntansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_buku_akuntansi', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kd_akun_akuntansi');
            $table->integer('kd_bank');
            $table->integer('nominal_akun');
            $table->integer('kd_pembuat');
            $table->integer('kd_terakhir_update');
            $table->timestamps();
            $table->index(['kd_akun_akuntansi', 'kd_bank'], 'index_akun_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_buku_akuntansi');
    }
}
