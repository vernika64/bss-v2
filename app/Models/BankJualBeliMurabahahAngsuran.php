<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankJualBeliMurabahahAngsuran extends Model
{
    use HasFactory;

    protected $table        = 'bank_jualbeli_murabahah_angsuran';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_angsuran_murabahah',
        'kd_transaksi_murabahah',
        'tgl_bayar_angsuran',
        'angsuran_ke',
        'nominal_bayar',
        'sisa_angsuran',
        'kd_admin'
    ];
}
