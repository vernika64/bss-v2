<?php

namespace App\Http\Controllers;

use App\Models\SysBank;
use App\Models\SysGrup;
use App\Models\SysUser;
use App\Models\SysUserAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Administrator extends Controller
{
    protected $admin_test = 1;

    public function getMemberDataAll(Request $re)
    {
        try {
            $ModelUser = SysUser::whereNotIn('sys_user.id', [1])->leftJoin('sys_grup', 'sys_user.kd_grup', '=', 'sys_grup.id')
                        ->leftjoin('sys_bank', 'sys_user.kd_bank', '=', 'sys_bank.id')
                        ->get(['nama_lengkap', 'uid', 'nama_grup', 'nama_bank']);

                    
            return response()->json([
                'data'      => $ModelUser,
                'status'    => 'getdata_success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);

        }
    }

    public function addNewMember(Request $re)
    {
        try {
            $ModelMahasiswa = new SysUser;

            $ModelMahasiswa->uid            = $re->no_id;
            $ModelMahasiswa->tipe_id        = $re->tipe_id;
            $ModelMahasiswa->nama_lengkap   = $re->nama_l;
            $ModelMahasiswa->kd_grup        = $re->grup;
            $ModelMahasiswa->kd_admin       = $this->admin_test;

            $ModelMahasiswa->save();

            return response()->json([
                'status'      => 'insert_success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function getBankList()
    {
        try {
            $ModelBank = SysBank::get(['kd_bank', 'nama_bank', 'alamat_bank']);

            return response()->json([
                'data'          => $ModelBank,
                'status'        => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function addBankNew(Request $re)
    {
        try {
            $ModelBank = new SysBank;

            $ModelBank->kd_bank     = Carbon::now()->format('Y-m-d') . '-' . SysBank::count();
            $ModelBank->nama_bank   = $re->namabank;
            $ModelBank->alamat_bank = $re->alamatbank;
            $ModelBank->kd_admin    = $this->admin_test;
            $ModelBank->save();

            return response()->json([
                'status'      => 'insert_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

}
