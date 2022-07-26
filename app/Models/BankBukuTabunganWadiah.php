<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBukuTabunganWadiah extends Model
{
    use HasFactory;

    protected $table        = 'bank_buku_tabungan_wadiah';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'id',
        'kd_produk_tabungan',
        'kd_buku_tabungan',
        'kd_cif',
        'kd_bank',
        'total_nilai',
        'kd_admin'
    ];
}
