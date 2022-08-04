<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysBukuJurnalUmum extends Model
{
    use HasFactory;

    protected $table        = 'sys_buku_jurnal_umum';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_transaksi_akuntansi',
        'tgl_pencatatan_jurnal',
        'nama_transaksi',
        'nominal_transaksi',
        'deskripsi',
        'status_transaksi',
        'kd_admin',
        'kd_bank'
    ];
}
