<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCIF extends Model
{
    use HasFactory;

    protected $table        = 'bank_cif';
    protected $primaryKeys  = 'id';
    protected $fillable     = [
        'id',
        'kd_identitas',
        'tipe_id',
        'nama_sesuai_identitas',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'status_kawin',
        'kewarganegaraan',
        'alamat_sekarang',
        'rt_rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'no_telp',
        'email',
        'nama_ibu_kandung',
        'status_pekerjaan',
        'kd_user',
        'kd_bank'
    ];

}
