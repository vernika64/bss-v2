<?php

namespace App\Http\Controllers;

use App\Models\SysUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserManagement extends Controller
{
    public function getDataUserAll()
    {
        $data = new SysUser;

        $ambil_data = $data->all();

        try {
            
            return response([
                'data'      => $ambil_data,
                'status'    => 'success'
            ]);

        } catch (\Exception $e) {
            return response([
                'message'               => 'server error',
                'detail'                => $e,
                'status'                => 'error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDataUserWithDesc()
    {
        $data = new SysUser;

        $data2 = $data
                 ->join('sys_grup', 'sys_user.kd_grup', '=', 'sys_grup.id')
                 ->join('sys_tipe_id', 'sys_user.tipe_id', '=', 'sys_tipe_id.id')
                 ->get([
                    'nama_lengkap',
                    'nama_grup',
                    'nama_kartu'
                 ]);

        return response($data2);
    }
}
