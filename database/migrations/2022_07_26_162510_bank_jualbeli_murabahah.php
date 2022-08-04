<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankJualbeliMurabahah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_jualbeli_murabahah', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal_transaksi_murabahah');
            $table->string('kd_transaksi_murabahah');
            $table->integer('kd_bank');
            $table->integer('kd_cif');
            $table->string('nama_permintaan');
            $table->text('deskripsi_permintaan');
            $table->bigInteger('harga_barang_satuan')->nullable();
            $table->integer('kuantitas_barang')->nullable();
            $table->enum('tipe_kuantitas', ['qty'])->nullable();
            $table->bigInteger('uang_muka')->nullable();
            $table->integer('frekuensi_angsuran')->nullable();
            $table->bigInteger('jumlah_angsuran')->nullable();
            $table->bigInteger('surplus_murabahah')->nullable();
            $table->string('link_lampiran')->nullable();
            $table->enum('status_transaksi', ['pending', 'active', 'pass', 'fail', 'reject']);
            $table->integer('status_admin_pembuat')->nullable();
            $table->integer('status_admin_acc')->nullable();
            $table->integer('status_admin_reject')->nullable();
            $table->text('desc_penolakan')->nullable();
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
        Schema::dropIfExists('bank_jualbeli_murabahah');
    }
}
