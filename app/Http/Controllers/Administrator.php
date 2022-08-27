<?php

namespace App\Http\Controllers;

use App\Models\SysBank;
use App\Models\SysBukuAkuntansi;
use App\Models\SysMasterBukuAkuntansi;
use App\Models\SysRole;
use App\Models\SysToken;
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
                ->join('sys_bank', 'sys_user.kd_bank', '=', 'sys_bank.id')
                ->join('sys_role', 'sys_user.role', '=', 'sys_role.kd_role')
                ->get(['fname', 'nama_bank', 'nama_role']);

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
            $ModelBank = SysBank::where('kd_bank', $bankKeys)->first();

            if(empty($ModelBank))
            {
                return response()->json([
                    'message'   => 'Bank tidak ditemukan',
                    'status'    => false
                ]);
            }

            $ModelUser = SysUser::where('kd_bank', $ModelBank->id)
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
            $ModelUser->fname          = $re->username;
            $ModelUser->role           = $re->pekerjaan;
            $ModelUser->kd_bank        = $re->bankTujuan;
            $ModelUser->save();

            $ModelBank = SysBank::find($re->bankTujuan);
            
            return response()->json([
                'status'      => true,
                'message'     => $username . ' berhasil ditambahkan dan terdaftar di ' . $ModelBank->nama_bank
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false,
                'message'   => 'Server Error!'
            ]);
        }
    }

    public function getBankList()
    {
        try {
            $ModelBank = SysBank::get(['id', 'kd_bank', 'nama_bank', 'alamat_bank']);

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

            $ModelBank->kd_bank         = Carbon::now()->format('Y-m-d') . '-' . $kalkulasiJumlahBank; // Format : Tahun - Bulan - Hari - Jumlah Bank yang terdaftar di database
            $ModelBank->nama_bank       = $re->namabank;
            $ModelBank->kd_unik_bank    = 200 + $kalkulasiJumlahBank;
            $ModelBank->alamat_bank     = $re->alamatbank;
            $ModelBank->kd_admin        = $this->admin_test;
            $ModelBank->save();

            $ModelBukuAkuntansi = new SysBukuAkuntansi;

            // Kelompok Buku, Kode Akun, Kode Bank, 
            $BukuKasOperasional = [1, 11001, 1, ];

            return response()->json([
                'status'        => true,
                'message'       => $re->namabank . ' berhasil ditambahkan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false,
                'message'   => 'Server Error!'
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

    public function getSysMasterBukuAkuntansiAll(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::all();

            return response()->json([
                'data'      => $ModelMasterBukuAkuntansi,
                'status'    => true
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function cekSubMasterBukuAkuntansi($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::where('kd_sub_master_buku', $id)->first();

            if(!empty($ModelMasterBukuAkuntansi))
            {
                return response()->json([
                    'message'       => 'Nomor akun sudah dipakai, coba isikan nomor lain',
                    'status'        => false
                ]);
            }

            return response()->json([
                'message'           => 'Nomor akun dapat dipakai',
                'status'            => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }
}
