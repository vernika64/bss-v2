<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBukuAkuntansi extends Model
{
    use HasFactory;

    protected $table        = 'bank_buku_akuntansi';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_akun_akuntansi',
        'kd_bank',
        'nominal_akun',
        'kd_pembuat',
        'kd_terakhir_update'
    ];
}
