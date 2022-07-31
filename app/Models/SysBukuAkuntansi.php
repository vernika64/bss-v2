<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysBukuAkuntansi extends Model
{
    use HasFactory;

    protected $table        = 'sys_buku_akuntansi';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_master_buku',
        'kd_sub_master_buku',
        'kd_bank',
        'nama_buku',
        'nominal',
        'kd_admin'
    ];
}
