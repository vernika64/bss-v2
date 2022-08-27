<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysMasterBukuAkuntansi extends Model
{
    use HasFactory;

    protected $table            = 'sys_master_buku_akuntansi';
    protected $primaryKey       = 'id';
    protected $fillable         = ['kd_master_buku', 'kd_sub_master_buku', 'nama_buku', 'kd_admin'];
}
