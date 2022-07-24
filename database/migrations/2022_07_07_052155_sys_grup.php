<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SysGrup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sys_grup', function(Blueprint $table) {
        //     $table->id();
        //     $table->string('kd_grup');
        //     $table->string('nama_grup');
        //     $table->string('deskripsi_grup')->nullable();
        //     $table->integer('kd_admin');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_grup');
    }
}
