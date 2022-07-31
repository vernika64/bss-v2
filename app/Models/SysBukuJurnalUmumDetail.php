<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysBukuJurnalUmumDetail extends Model
{
    use HasFactory;

    protected $table        = 'sys_buku_jurnal_umum_detail';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_transaksi_akuntansi',
        'kd_buku_akuntansi',
        'nominal_debit',
        'nominal_kredit',
        'deskripsi',
        'kd_admin',
        'kd_bank'
    ];
}
