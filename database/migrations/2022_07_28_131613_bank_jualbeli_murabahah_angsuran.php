<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankJualbeliMurabahahAngsuran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_jualbeli_murabahah_angsuran', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_angsuran_murabahah');
            $table->string('kd_transaksi_murabahah');
            $table->date('tgl_bayar_angsuran');
            $table->string('angsuran_ke');
            $table->string('nominal_bayar');
            $table->string('sisa_angsuran');
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
        Schema::dropIfExists('bank_jualbeli_murabahah_angsuran');
    }
}
