<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankJualBeliMurabahah extends Model
{
    use HasFactory;

    protected $table        = 'bank_jualbeli_murabahah';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'tanggal_transaksi_murabahah',
        'kd_transaksi_murabahah',
        'kd_bank',
        'kd_nasabah',
        'nama_permintaan',
        'deskripsi_permintaan',
        'status_transaksi',
        'status_admin_pembuat',
        'status_admin_acc',
        'status_admin_reject'
    ];

}
