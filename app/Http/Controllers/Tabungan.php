<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use App\Models\BankCIF;
use App\Models\BankTransaksiTabunganWadiah;
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

    public function getDataTabunganForTransaksi($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                // return response('Error 403 - Forbidden', 403);
                return response()->json([
                    'message'   => 'Token tidak ditemukan'
                ]);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                // return response('Error 404 - User not found', 404);
                return response()->json([
                    'message'   => 'User tidak ditemukan'
                ]);
            }

            $kodeadmin   = $ModelUser->id;
            $kodebank    = $ModelUser->kd_bank;
            
            $ModelTabungan          = BankBukuTabunganWadiah::where('kd_buku_tabungan', $id)->first();


            if($ModelTabungan->kd_bank == $kodebank)
            {
                $ModelCIF               = BankCIF::find($ModelTabungan->kd_cif);

                $ModelProdukTabungan            = SysProdukTabungan::find($ModelTabungan->kd_produk_tabungan);
                $ModelNotaTransaksiTabungan     = BankTransaksiTabunganWadiah::count();
                $TambahIntervalUntukNotaFisik   = $ModelNotaTransaksiTabungan + 1;

                if(empty($ModelCIF))
                {
                    return response()->json([
                        'message'       => 'Nasabah tidak ditemukan',
                        'status'        => false
                    ]);
                } elseif(empty($ModelProdukTabungan))
                {
                    return response()->json([
                        'message'       => 'Produk Tabungan Tidak Terdaftar',
                        'status'        => false
                    ]);
                }

                $data = [
                    'kd_buku_tabungan'  => $ModelTabungan->kd_buku_tabungan,
                    'nama_nasabah'      => $ModelCIF->nama_sesuai_identitas,
                    'produk_tabungan'   => $ModelProdukTabungan->nama_produk,
                    'nilai_tabungan'    => $ModelTabungan->total_nilai,
                    'no_nota_fisik'     => Carbon::now()->format('Y-m-d') . '-' . $TambahIntervalUntukNotaFisik
                ];

                return response()->json([
                    'message'   => 'Tabungan terdaftar di bank ini',
                    'status'    => true,
                    'data'      => $data
                ]);
            } else if($ModelTabungan->kd_bank != $kodebank) {
                return response()->json([
                    'message'   => 'Tabungan tidak terdaftar di bank ini',
                    'status'    => false
                ]);
            }
            
            
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

    public function insertTransaksiTabungan(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                // return response('Error 403 - Forbidden', 403);
                return response()->json([
                    'message'   => 'Token tidak ditemukan'
                ]);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                // return response('Error 404 - User not found', 404);
                return response()->json([
                    'message'   => 'User tidak ditemukan'
                ]);
            }

            $kodeadmin   = $ModelUser->id;
            $kodebank    = $ModelUser->kd_bank;

            $ModelTabungan = BankBukuTabunganWadiah::where('kd_buku_tabungan', $re->kd_buku_tabungan)->first();

            if(empty($ModelTabungan))
            {
                return response()->json([
                    'message'   => 'Tabungan tidak terdaftar di bank ini',
                    'status'    => false
                ]);
            }

            if($re->jenis_transaksi == 'tarik') {
                $HitungSisaTabungan = $ModelTabungan->total_nilai - $re->nominal_transaksi;

                if($HitungSisaTabungan < 0)
                {
                    return response()->json([
                        'message'   => 'Tabungan tidak cukup',
                        'status'    => false
                    ]);
                }

                $CountIsiTabel          = BankTransaksiTabunganWadiah::count();
                $KalkulasiCount         = $CountIsiTabel + 1;
                $FormatKodeTabungan     = 'TB-TK-' . Carbon::now()->format('Y-m-d') . '-' . $KalkulasiCount;

                $ModelTarikTabungan = new BankTransaksiTabunganWadiah;
                $ModelTarikTabungan->kd_transaksi_tabungan = $FormatKodeTabungan;
                $ModelTarikTabungan->kd_buku_tabungan      = $re->kd_buku_tabungan;
                $ModelTarikTabungan->jenis_transaksi       = $re->jenis_transaksi;
                $ModelTarikTabungan->nominal_transaksi     = $re->nominal_transaksi;
                $ModelTarikTabungan->kd_admin              = $kodeadmin;
                $ModelTarikTabungan->kd_bank               = $kodebank;
                $ModelTarikTabungan->save();

                $ModelUpdateNominalTabungan                 = BankBukuTabunganWadiah::where('kd_buku_tabungan', $re->kd_buku_tabungan)->first();
                $ModelUpdateNominalTabungan->total_nilai    = $HitungSisaTabungan;
                $ModelUpdateNominalTabungan->save();
                
                return response()->json([
                    'message'       => 'Transaksi Tarik Tunai Berhasil disimpan',
                    'status'        => true
                ]);

            } else if($re->jenis_transaksi == 'setor') {
                $TambahTabungan = $ModelTabungan->total_nilai + $re->nominal_transaksi;

                $ModelIsiTabungan = new BankTransaksiTabunganWadiah;
                
                $CountIsiTabel          = BankTransaksiTabunganWadiah::count();
                $KalkulasiCount         = $CountIsiTabel + 1;
                $FormatKodeTabungan     = 'TB-TK-' . Carbon::now()->format('Y-m-d') . '-' . $KalkulasiCount;

                $ModelIsiTabungan = new BankTransaksiTabunganWadiah;
                $ModelIsiTabungan->kd_transaksi_tabungan = $FormatKodeTabungan;
                $ModelIsiTabungan->kd_buku_tabungan      = $re->kd_buku_tabungan;
                $ModelIsiTabungan->jenis_transaksi       = $re->jenis_transaksi;
                $ModelIsiTabungan->nominal_transaksi     = $re->nominal_transaksi;
                $ModelIsiTabungan->kd_admin              = $kodeadmin;
                $ModelIsiTabungan->kd_bank               = $kodebank;
                $ModelIsiTabungan->save();

                $ModelUpdateNominalTabungan                 = BankBukuTabunganWadiah::where('kd_buku_tabungan', $re->kd_buku_tabungan)->first();
                $ModelUpdateNominalTabungan->total_nilai    = $TambahTabungan;
                $ModelUpdateNominalTabungan->save();

                return response()->json([
                    'message'       => 'Setor Tunai Berhasil ditambahkan',
                    'status'        => true
                ]);
            } else {
                return response()->json([
                    'message'       => 'Jenis Transaksi Tidak terdaftar',
                    'status'        => true
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

}
