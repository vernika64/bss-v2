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
            $ModelUser = SysUser::whereNotIn('sys_user.id', [1])
                ->join('sys_bank', 'sys_user.kd_bank', '=', 'sys_bank.kd_bank')
                ->get(['username', 'nama_bank', 'role']);

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
            $ModelUser = new SysUser;

            $ModelUser->username       = $re->username;
            $ModelUser->password       = Hash::make($re->username);
            $ModelUser->role           = $re->pekerjaan;
            $ModelUser->kd_bank        = $re->bankTujuan;
            $ModelUser->save();

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

    public function getBankListById($id)
    {
        try {
            $ModelBank = SysBank::where('kd_bank', $id)->first();

            if (!$ModelBank) {
                return response()->json([
                    'status'        => 'data_notfound'
                ]);
            }

            return response()->json([
                'data'              => $ModelBank->get()
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

            $kalkulasiJumlahBank    = SysBank::count() + 1;

            $ModelBank->kd_bank     = Carbon::now()->format('Y-m-d') . '-' . $kalkulasiJumlahBank; // Format : Tahun - Bulan - Hari - Jumlah Bank yang terdaftar di database
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
