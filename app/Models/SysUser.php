<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUser extends Model
{
    use HasFactory;

    protected $table = 'sys_user';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'username', 'password', 'role' , 'kd_bank'];
}
