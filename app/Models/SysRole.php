<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysRole extends Model
{
    use HasFactory;

    protected $table        = 'sys_role';
    protected $fillable     = ['id', 'kd_role', 'nama_role'];
}
