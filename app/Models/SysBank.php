<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysBank extends Model
{
    use HasFactory;

    protected $table        = 'sys_bank';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_bank',
        'kd_unik_bank',
        'nama_bank',
        'alamat_bank',
        'kd_admin'
    ];
    
}
