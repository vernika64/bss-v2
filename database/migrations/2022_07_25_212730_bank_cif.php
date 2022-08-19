<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankCif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cif', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_identitas');
            $table->enum('tipe_id', ['ktp', 'ktm']);
            $table->string('nama_sesuai_identitas');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['laki', 'perempuan']);
            $table->enum('status_kawin', ['belum', 'sudah', 'janda', 'duda']);
            $table->string('kewarganegaraan');
            $table->string('alamat_sekarang');
            $table->string('rt_rw');
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('no_telp');
            $table->string('email');
            $table->string('nama_ibu_kandung');
            $table->string('status_pekerjaan');
            $table->integer('kd_user');
            $table->integer('kd_bank');
            $table->timestamps();
            $table->unique(['kd_identitas', 'tipe_id'], 'index_kode_cif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_cif');
    }
}
