<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use App\Models\BankCIF;
use App\Models\SysBank;
use App\Models\SysProdukTabungan;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Tabungan extends Controller
{
    public function getDataProdukTabungan()
    {
        try {
            $ModelProdukTabungan = SysProdukTabungan::get(['id', 'nama_produk']);

            return response()->json([
                'data'          => $ModelProdukTabungan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server Error'
            ]);
        }
    }

    public function getDataTabunganForTabel(Request $re)
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


            $ModelProdukTabungan = BankBukuTabunganWadiah::where('bank_buku_tabungan_wadiah.kd_bank', $ModelUser->kd_bank)
                                                            ->join('bank_cif', 'bank_cif.id', '=',  'bank_buku_tabungan_wadiah.kd_cif')
                                                            ->join('sys_produk_tabungan', 'sys_produk_tabungan.id', '=', 'bank_buku_tabungan_wadiah.kd_produk_tabungan')
                                                            ->get(['kd_buku_tabungan', 'nama_sesuai_identitas', 'nama_produk']);

            return response()->json([
                'data'          => $ModelProdukTabungan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server Error'
            ]);
        }
    }

    public function insertDataTabungan(Request $re)
    {
        try {

            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $getUserData = SysUser::where('username', $ModelToken->kd_user)->first();
            $getBankData = SysBank::find($getUserData->kd_bank);

            if(empty($getBankData))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $cektabungan = BankBukuTabunganWadiah::where('kd_cif', $re->kd_cif)->first();

            if(empty($cektabungan)) {
                // No Action
            } else if(!empty($cektabungan)) {
                if($cektabungan->kd_produk_tabungan == $re->kd_produk_tabungan)
                {
                    return response()->json([
                        'message' => 'Produk tabungan ini sudah terdaftar di data nasabah'
                    ]);
                }
            }

            $kodeunikbank   = $getBankData->kd_unik_bank;
            $kodebank       = $getBankData->id;
            $kdadmin        = $getUserData->id;

            // Data dari form

            $produk_tabungan = $re->kd_produk_tabungan;
            $kode_nasabah    = $re->kd_cif;

            $hitungtabungan = BankBukuTabunganWadiah::count() + 1;

            $formatbukutabungan = $kodeunikbank . '-' . Carbon::now()->format('Y-m-d') . '-' . $hitungtabungan;

            $ModelBankBukuTabunganWadiah                        = new BankBukuTabunganWadiah;
            $ModelBankBukuTabunganWadiah->kd_produk_tabungan    = $produk_tabungan;
            $ModelBankBukuTabunganWadiah->kd_buku_tabungan      = $formatbukutabungan;
            $ModelBankBukuTabunganWadiah->kd_cif                = $kode_nasabah;
            $ModelBankBukuTabunganWadiah->kd_bank               = $kodebank;
            $ModelBankBukuTabunganWadiah->total_nilai           = 0;
            $ModelBankBukuTabunganWadiah->kd_admin              = $kdadmin;
            $ModelBankBukuTabunganWadiah->save();

            return response()->json([
                'message'       => 'Tabungan berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

}
