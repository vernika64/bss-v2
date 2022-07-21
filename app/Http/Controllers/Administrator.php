<?php

namespace App\Http\Controllers;

use App\Models\SysBank;
use App\Models\SysRole;
use App\Models\SysUser;
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
                ->join('sys_role', 'sys_user.role', '=', 'sys_role.kd_role')
                ->get(['username', 'nama_bank', 'nama_role']);

            if (empty($ModelUser)) {
                // Jika nilainya 0 atau NULL
                return "datanya gada";
            }

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

    public function getMemberDataByBankId($bankKeys)
    {
        try {
            $ModelUser = SysUser::where('kd_bank', $bankKeys)
                         ->join('sys_role', 'sys_user.role', '=', 'sys_role.kd_role')
                         ->get(['username', 'nama_role']);

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

            $username = strtolower($re->username);

            $ModelUser->username       = $username;
            $ModelUser->password       = Hash::make($username);
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

    public function getBankListById($keys)
    {
        try {

            $ModelBank = SysBank::where('kd_bank', '2022-06-13-1')->firstOrFail();

            if (!$ModelBank) {
                return response()->json([
                    'status'        => 'data_notfound'
                ]);
            }

            return response()->json([
                'data'              => $ModelBank
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
            // $kalkulasiJumlahBank    = SysBank::increment();

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

    public function getRoleList()
    {
        try {
            $ModelRole = SysRole::whereNotIn('kd_role', ['admin'])->get(['kd_role', 'nama_role']);

            return response()->json([
                'data'      => $ModelRole,
                'status'    => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }
}
