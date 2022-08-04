<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPermintaanBarangMurabahah extends Model
{
    use HasFactory;

    protected $table        = 'bank_permintaan_barang_murabahah';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_transaksi_murabahah',
        'tgl_permintaan_barang_dibuat',
        'tgl_permintaan_barang_diterima',
        'tgl_permintaan_barang_keluar',
        'kd_bank',
        'kd_invoice_barang',
        'nama_barang',
        'harga_barang',
        'foto_barang',
        'keterangan',
        'status_barang',
        'kd_admin'
    ];
}
