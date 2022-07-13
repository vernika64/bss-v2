<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_bank', function(Blueprint $table) {
            $table->id();
            $table->string('kd_bank');      // TAHUN-BULAN-HARI-BANK_COUNT_IN_DATABASE
            $table->string('nama_bank');
            $table->string('alamat_bank');
            $table->string('kd_admin');
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
        Schema::dropIfExists('sys_bank');
    }
}
