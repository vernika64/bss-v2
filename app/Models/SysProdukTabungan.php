<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysProdukTabungan extends Model
{
    use HasFactory;

    protected $table            = 'sys_produk_tabungan';
    protected $primaryKey       = 'id';
    protected $fillable         = [
        'kd_produk',
        'nama_produk',
        'keterangan',
        'kd_admin'
    ];
}
