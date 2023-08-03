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
use stdClass;

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

            if (empty($ModelToken)) {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if (empty($ModelUser)) {
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
            $token                              = $re->cookie('tkn');
            $tipe_id                            = $re->tipe_id;
            $kd_identitas                       = $re->kd_identitas;
            $kd_produk_tabungan                 = $re->kd_produk_tabungan;

            $ModelUser                          = new SysUser();

            $data_user                          = $ModelUser->getInformasiUser($token);
            
            $data_bank                          = SysBank::find($data_user->kd_bank)->first();

            $ModelCIF                           = new BankCIF();

            $data_pencarian = new stdClass;
            $data_pencarian->tipe_id            = $tipe_id;
            $data_pencarian->kd_identitas       = $kd_identitas;
            $data_pencarian->kd_bank            = $data_user->kd_bank;

            $data_pencarian;

            $data_cif                           = $ModelCIF->cariInfoCIFByIdDanBank($data_pencarian);

            if($data_cif == true) {

                $hitung_tabungan                            = BankBukuTabunganWadiah::count() + 1;
                    
                $format_buku_tabungan                       = $data_bank->kd_unik_bank . '-' . Carbon::now()->format('Y-m-d') . '-' . $hitung_tabungan;

                $data_buat_diinput                          = new stdClass;
                $data_buat_diinput->kd_bank                 = $data_user->kd_bank;
                $data_buat_diinput->kd_admin                = $data_user->user_id;
                $data_buat_diinput->kd_cif                  = $data_cif->id;
                $data_buat_diinput->format_buku_tabungan    = $format_buku_tabungan;
                $data_buat_diinput->kd_produk_tabungan      = $kd_produk_tabungan;

                $data_buat_diinput;
                
                $ModelTabungan                              = new BankBukuTabunganWadiah();
                $TambahBukuTabungan                         = $ModelTabungan->buatTabunganWadiah($data_buat_diinput);

                if($TambahBukuTabungan->status == true) {
                    
                    return response()->json([
                        'status'        => 200,
                        'message'       => 'Tabungan berhasil disimpan',
                        'kd_tabungan'   => $format_buku_tabungan,
                        'qr_status'     => true
                    ]);

                } else if($TambahBukuTabungan->status == false) {

                    return response()->json([
                        'status'        => 200,
                        'message'       => 'Tabungan gagal disimpan, silahkan hubungi staff IT',
                        'qr_status'     => false
                    ]);

                } else {

                    return response()->json([
                        'status'        => 200,
                        'message'       => 'Tabungan gagal disimpan, silahkan hubungi staff IT',
                        'qr_status'     => false
                    ]);

                }

            } else if($data_cif == false) {

                return response()->json([
                    'status'        => 200,
                    'message'       => 'Data CIF tidak ditemukan',
                    'qr_status'     => false
                ]);

            } else {

                return response()->json([
                    'status'        => 400,
                    'message'       => 'Terjadi kesalahan pada saat menyimpan data tabungan, silahkan hubungi staff IT',
                    'qr_status'     => false
                ]);

            }
        } catch (\Throwable $th) {
            $err       = new MetodeBerguna;

            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }

    public function getDataTabunganForTransaksi($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if (empty($ModelToken)) {
                // return response('Error 403 - Forbidden', 403);
                return response()->json([
                    'message'   => 'Token tidak ditemukan'
                ]);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if (empty($ModelUser)) {
                // return response('Error 404 - User not found', 404);
                return response()->json([
                    'message'   => 'User tidak ditemukan'
                ]);
            }

            $kodeadmin   = $ModelUser->id;
            $kodebank    = $ModelUser->kd_bank;

            $ModelTabungan          = BankBukuTabunganWadiah::where('kd_buku_tabungan', $id)->first();


            if ($ModelTabungan->kd_bank == $kodebank) {
                $ModelCIF               = BankCIF::find($ModelTabungan->kd_cif);

                $ModelProdukTabungan            = SysProdukTabungan::find($ModelTabungan->kd_produk_tabungan);
                $ModelNotaTransaksiTabungan     = BankTransaksiTabunganWadiah::count();
                $TambahIntervalUntukNotaFisik   = $ModelNotaTransaksiTabungan + 1;

                if (empty($ModelCIF)) {
                    return response()->json([
                        'message'       => 'Nasabah tidak ditemukan',
                        'status'        => false
                    ]);
                } elseif (empty($ModelProdukTabungan)) {
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
            } else if ($ModelTabungan->kd_bank != $kodebank) {
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

            if (empty($ModelToken)) {
                // return response('Error 403 - Forbidden', 403);
                return response()->json([
                    'message'   => 'Token tidak ditemukan'
                ]);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if (empty($ModelUser)) {
                // return response('Error 404 - User not found', 404);
                return response()->json([
                    'message'   => 'User tidak ditemukan'
                ]);
            }

            $kodeadmin   = $ModelUser->id;
            $kodebank    = $ModelUser->kd_bank;

            $ModelTabungan = BankBukuTabunganWadiah::where('kd_buku_tabungan', $re->kd_buku_tabungan)->first();

            if (empty($ModelTabungan)) {
                return response()->json([
                    'message'   => 'Tabungan tidak terdaftar di bank ini',
                    'status'    => false
                ]);
            }

            if ($re->jenis_transaksi == 'tarik') {
                $HitungSisaTabungan = $ModelTabungan->total_nilai - $re->nominal_transaksi;

                if ($HitungSisaTabungan < 50000) {
                    return response()->json([
                        'message'   => 'Tabungan tidak dapat ditarik, saldo kurang',
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
                $ModelTarikTabungan->no_nota_fisik         = $re->no_nota_fisik;
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
            } else if ($re->jenis_transaksi == 'setor') {
                $TambahTabungan = $ModelTabungan->total_nilai + $re->nominal_transaksi;

                $ModelIsiTabungan = new BankTransaksiTabunganWadiah;

                $CountIsiTabel          = BankTransaksiTabunganWadiah::count();
                $KalkulasiCount         = $CountIsiTabel + 1;
                $FormatKodeTabungan     = 'TB-TK-' . Carbon::now()->format('Y-m-d') . '-' . $KalkulasiCount;

                $ModelIsiTabungan = new BankTransaksiTabunganWadiah;
                $ModelIsiTabungan->kd_transaksi_tabungan = $FormatKodeTabungan;
                $ModelIsiTabungan->kd_buku_tabungan      = $re->kd_buku_tabungan;
                $ModelIsiTabungan->jenis_transaksi       = $re->jenis_transaksi;
                $ModelIsiTabungan->no_nota_fisik         = $re->no_nota_fisik;
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
                    'status'        => false
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => 'Unknown Error',
                'status'    => false
            ]);
        }
    }

    public function getDataTotalNilaiTabunganWadiah(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if (empty($ModelToken)) {
                // return response('Error 403 - Forbidden', 403);
                return response()->json([
                    'message'   => 'Token tidak ditemukan'
                ]);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if (empty($ModelUser)) {
                // return response('Error 404 - User not found', 404);
                return response()->json([
                    'message'   => 'User tidak ditemukan'
                ]);
            }

            $kodeadmin   = $ModelUser->id;
            $kodebank    = $ModelUser->kd_bank;
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

    public function cariDataTabunganDariKodeBukuTabungan($id) {
        try {
            $kd_buku_tabungan           = $id;

            $ModelTabungan      = new BankBukuTabunganWadiah();

            $cari_data_tabungan = $ModelTabungan->cariDataTabunganByKodeBukuTabungan($kd_buku_tabungan);

            return response()->json([
                'status'                => 200,
                'message'               => $cari_data_tabungan->message,
                'qr_status'             => $cari_data_tabungan->status,
                'data'                  => $cari_data_tabungan->data,
                'kd_buku_tabungan'      => $kd_buku_tabungan
            ]);

        } catch (\Throwable $th) {
            $err       = new MetodeBerguna;

            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }

    public function hitungTotalTabunganWadiahBank(Request $re) {
        try {
            $token          = $re->cookie('tkn');
            $ModelUser      = new SysUser();

            $data_user      = $ModelUser->getInformasiUser($token);

            if($data_user->status == false) {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'User tidak terdaftar di sistem'
                ]);
            }

            $data_pencarian                 = new stdClass;
            $data_pencarian->kd_user        = $data_user->id;
            $data_pencarian->kd_bank        = $data_user->kd_bank;

            $ModelTabungan  = new BankBukuTabunganWadiah();
            $data_tabungan  = $ModelTabungan->hitungTotalTabunganWadiah($data_pencarian);

            return response()->json([
                'status'        => 200,
                'message'       => $data_tabungan->message,
                'data'          => $data_tabungan->data
            ]);
        } catch (\Throwable $th) {
            $err       = new MetodeBerguna;

            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }
}
