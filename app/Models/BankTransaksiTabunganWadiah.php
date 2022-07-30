<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransaksiTabunganWadiah extends Model
{
    use HasFactory;

    protected $table        = 'bank_transaksi_tabungan_wadiah';
    protected $primaryKey   = 'id';
    protected $fillable = [
        'kd_transaksi_tabungan',
        'kd_buku_tabungan',
        'jenis_transaksi',
        'nominal_transaksi',
        'kd_admin',
        'kd_bank'
    ];
}
