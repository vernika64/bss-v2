<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class SysUser extends Model
{
    use HasFactory;

    protected $table = 'sys_user';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'username', 'password', 'role' , 'kd_bank'];

    function getInformasiUser($token){
        $ModelToken = SysToken::where(['token' => $token])->first();

        if(!empty($ModelToken)) {
            $ModelUser  = SysUser::where(['username' => $ModelToken->kd_user])->first();

            if(!empty($ModelUser)) {
                $data           = new stdClass;
                $data->status   = true;
                $data->username = $ModelUser->username;
                $data->kd_bank  = $ModelUser->kd_bank;
                $data->role     = $ModelUser->role;
                
                return $data;
            } else {
                $data = new stdClass;
                $data->status   = false;
                $data->message  = 'Data user tidak ditemukan';

                return $data;
            }

        } else {
            $data = new stdClass;
            $data->status   = false;
            $data->message  = 'Token tidak terdaftar!';

            return $data;
        }
    }
}
