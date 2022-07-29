<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankPermintaanBarangMurabahah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_permintaan_barang_murabahah', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kd_transaksi_murabahah');
            $table->date('tgl_permintaan_barang_dibuat')->nullable();
            $table->date('tgl_permintaan_barang_diterima')->nullable();
            $table->date('tgl_permintaan_barang_keluar')->nullable();
            $table->integer('kd_bank');
            $table->string('kd_invoice_barang')->nullable();
            $table->string('nama_barang');
            $table->string('harga_barang_satuan');
            $table->string('kuantitas_barang');
            $table->enum('tipe_kuantitas', ['qty']);
            $table->string('foto_barang')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status_barang', ['pending', 'receive', 'out', 'fail']);
            $table->integer('kd_admin_buat');
            $table->integer('kd_admin_terima')->nullable();
            $table->integer('kd_admin_keluar')->nullable();
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
        Schema::dropIfExists('bank_permintaan_barang_murabahah');
    }
}
