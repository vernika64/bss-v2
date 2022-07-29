<?php

namespace App\Http\Controllers;

use App\Models\BankJualBeliMurabahah;
use App\Models\BankJualBeliMurabahahAngsuran;
use App\Models\BankPermintaanBarangMurabahah;
use App\Models\SysBank;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JualBeliMurabahah extends Controller
{
    public function getDataTransaksiMurabahah(Request $re)
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

            $ModelJualBeli = BankJualBeliMurabahah::where('bank_jualbeli_murabahah.kd_bank', $ModelUser->kd_bank)
                             ->join('bank_cif', 'bank_jualbeli_murabahah.kd_cif', '=', 'bank_cif.id')
                             ->get(['bank_jualbeli_murabahah.id','kd_transaksi_murabahah', 'nama_sesuai_identitas', 'nama_permintaan', 'status_transaksi']);

            if(empty($ModelJualBeli))
            {
                return response()->json([
                    'message'   => 'Data kosong'
                ]);
            }

            return response()->json([
                'data'      => $ModelJualBeli,
                'message'   => 'Data berhasil diambil'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

    public function getDataTransaksiMurabahahById($id, Request $re)
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

            $ModelJualBeli = BankJualBeliMurabahah::find($id);

            return response()->json([
                'data'  => $ModelJualBeli
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }
    
    public function insertTransaksiMurabahah(Request $re)
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

            $ModelBank = SysBank::find($ModelUser->kd_bank);

            $kodebank  = $ModelBank->id;
            $kodeadmin = $ModelUser->id;

            // Input yang dibutuhkan dari user admin
            $counttransaksi     = BankJualBeliMurabahah::count();
            $countadd           = $counttransaksi + 1;

            // Input yang dibutuhkan dari form
            $nasabah            = $re->kd_nasabah;
            $judul_permintaan   = $re->nama_permintaan;
            $deskripsi          = $re->deskripsi_permintaan;
            $link               = $re->link_pendukung;
            $status             = 'pending';                    // Pertama kali status dipending dahulu untuk diverifikasi oleh petugas back office
            
            $ModelJualBeli              = new BankJualBeliMurabahah;
            $ModelJualBeli->kd_transaksi_murabahah      = 'JB-MB-' . Carbon::now()->format('Y-m-d') . $countadd;
            $ModelJualBeli->tanggal_transaksi_murabahah = Carbon::now();
            $ModelJualBeli->kd_bank                     = $kodebank;
            $ModelJualBeli->kd_cif                      = $nasabah;
            $ModelJualBeli->nama_permintaan             = $judul_permintaan;
            $ModelJualBeli->deskripsi_permintaan        = $deskripsi;
            $ModelJualBeli->link_lampiran               = $link;
            $ModelJualBeli->status_transaksi            = $status;
            $ModelJualBeli->status_admin_pembuat        = $kodeadmin;
            $ModelJualBeli->save();
            
            return response()->json([
                'message'       => 'Permintaan berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function updateStatusToActive(Request $re)
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

            $kodeadmin = $ModelUser->id;
            $kodebank  = $ModelUser->kd_bank;

            $ModelJualBeli = BankJualBeliMurabahah::find($re->id);

            if(empty($ModelJualBeli))
            {
                return response()->json([
                    'message' => 'Akad belum terdaftar'
                ]);
            }

            $ModelJualBeli->status_transaksi = 'active';

            return response()->json([
                'message'   => 'Akad berhasil diverifikasi'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function rejectTransaksiMurabahah(Request $re)
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

            $kodeadmin      = $ModelUser->id;
            $kdtransaksi    = $re->kd_transaksi_murabahah;
            // $kodebank  = $ModelUser->kd_bank;

            $ModelJualBeli = BankJualBeliMurabahah::find($kdtransaksi);
            $ModelJualBeli->status_transaksi    = 'reject';
            $ModelJualBeli->status_admin_reject = $kodeadmin;
            $ModelJualBeli->desc_penolakan      = $re->desc_penolakan;
            $ModelJualBeli->save();

            return response()->json([
                'message'       => 'Permintaan berhasil ditolak'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function acceptTransaksiMurabahah(Request $re)
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
            $kdtransaksi = $re->kd_transaksi_murabahah;

            $angsuran           = $re->angsuran_per_bulan;
            $frekuensi          = $re->frekuensi_angsuran;
            $hargabarangsatuan  = $re->harga_barang_satuan;
            $namabarang         = $re->nama_barang;
            $kuantitas          = $re->qty_barang;
            $tipekuantitas      = $re->qty_type;
            $surplus            = $re->surplus_untuk_bank;
            $totalbiaya         = $re->total_biaya_akad_murabahah;
            $totalhargabarang   = $re->total_harga_barang;

            $ModelJualBeli                          = BankJualBeliMurabahah::find($kdtransaksi);

            if(empty($ModelJualBeli))
            {
                return response()->json([
                    'message'   => 'Transaksi Murabahah tidak ditemukan'
                ]);
            }

            $ModelJualBeli->harga_barang_satuan     = $hargabarangsatuan;
            $ModelJualBeli->kuantitas_barang        = $kuantitas;
            $ModelJualBeli->tipe_kuantitas          = $tipekuantitas;
            $ModelJualBeli->frekuensi_angsuran      = $frekuensi;
            $ModelJualBeli->jumlah_angsuran         = $totalbiaya;
            $ModelJualBeli->surplus_murabahah       = $surplus;
            $ModelJualBeli->status_admin_acc        = $kodeadmin;
            $ModelJualBeli->status_transaksi        = 'active';
            $ModelJualBeli->save();
        
            $ModelPermintaanBarang = new BankPermintaanBarangMurabahah;
        
            $ModelPermintaanBarang->kd_transaksi_murabahah          = $kdtransaksi;
            $ModelPermintaanBarang->tgl_permintaan_barang_dibuat    = Carbon::now();
            $ModelPermintaanBarang->kd_bank                         = $kodebank;
            $ModelPermintaanBarang->nama_barang                     = $namabarang;
            $ModelPermintaanBarang->harga_barang_satuan             = $hargabarangsatuan;
            $ModelPermintaanBarang->kuantitas_barang                = $kuantitas;
            $ModelPermintaanBarang->tipe_kuantitas                  = $tipekuantitas;
            $ModelPermintaanBarang->status_barang                   = 'pending';
            $ModelPermintaanBarang->kd_admin_buat                   = $kodeadmin;
            $ModelPermintaanBarang->save();

            return response()->json([
                'message'       => 'Permintaan berhasil diverifikasi dan bisa mulai proses pembelian barang dari supplier'
            ]);

            } catch (\Throwable $th) {
                return response()->json([
                    'data'      => $th->getMessage(),
                    'status'    => 'Server error',
                    'message'   => 'Server Error'
                ]);
            }
    }

    public function getDataPermintaanBarang(Request $re)
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

            $ModelPermintaanBarang = BankPermintaanBarangMurabahah::where('bank_permintaan_barang_murabahah.kd_bank', $kodebank)
                                     ->join('bank_jualbeli_murabahah', 'bank_permintaan_barang_murabahah.kd_transaksi_murabahah', '=', 'bank_jualbeli_murabahah.id')
                                     ->get(['bank_permintaan_barang_murabahah.id','bank_jualbeli_murabahah.kd_transaksi_murabahah', 'nama_barang', 'status_barang']);

            return response()->json([
                'data'      => $ModelPermintaanBarang
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function terimaBarangKeBank(Request $re)
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

            $kd_permintaan_barang   = $re->kd_permintaan_barang;
            $kd_invoice_barang      = $re->kd_invoice_barang;
            $keterangan             = $re->keterangan;

            $ModelPermintaanBarang = BankPermintaanBarangMurabahah::find($kd_permintaan_barang);

            if(empty($ModelPermintaanBarang))
            {
                return response()->json([
                    'message'       => 'Data gagal disimpan, transaksi tidak ditemukan di sistem'
                ]);
            }

            $ModelPermintaanBarang->tgl_permintaan_barang_diterima  = Carbon::now();
            $ModelPermintaanBarang->kd_invoice_barang               = $kd_invoice_barang;
            $ModelPermintaanBarang->keterangan                      = $keterangan;
            $ModelPermintaanBarang->status_barang                   = 'receive';
            $ModelPermintaanBarang->kd_admin_terima                 = $kodeadmin;
            $ModelPermintaanBarang->save();

            return response()->json([
                'message'       => 'Barang telah diterima dan dicatat di dalam sistem'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function keluarBarangKeNasabah(Request $re)
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

            $kd_permintaan_barang   = $re->kd_permintaan_barang;

            $ModelPermintaanBarang = BankPermintaanBarangMurabahah::find($kd_permintaan_barang);

            if(empty($ModelPermintaanBarang))
            {
                return response()->json([
                    'message'   => 'Permintaan barang tidak ditemukan'
                ]);
            }

            $ModelPermintaanBarang->tgl_permintaan_barang_keluar = Carbon::now();
            $ModelPermintaanBarang->status_barang                = 'out';
            $ModelPermintaanBarang->kd_admin_keluar              = $kodeadmin;
            $ModelPermintaanBarang->save();

            return response()->json([
                'message'   => 'Barang telah dicatat keluar dari sistem'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function cariTransaksiMurabahahUntukAngsuran($id, Request $re)
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

            $ModelJualBeli = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $id)->first();
            
            if(empty($ModelJualBeli))
            {
                return response()->json([
                    'message'       => 'Transaksi murabahah tidak ditemukan',
                    'status'        => 'error'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'pending')
            {
                return response()->json([
                    'message'       => 'Transaksi masih belum diverifikasi',
                    'status'        => 'error'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'pass')
            {
                return response()->json([
                    'message'       => 'Transaksi sudah lunas',
                    'status'        => 'error'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'fail')
            {
                return response()->json([
                    'message'       => 'Transaksi sudah diverifikasi gagal bayar',
                    'status'        => 'error'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'reject')
            {
                return response()->json([
                    'message'       => 'Transaksi tidak lolos verifikasi',
                    'status'        => 'error'
                ]);
            }

            $ModelAngsuran = BankJualBeliMurabahahAngsuran::where('kd_transaksi_murabahah', $id)->count();

            if(empty($ModelAngsuran))
            {
                $ModelJualBeliAwal  = BankJualBeliMurabahah::where('bank_jualbeli_murabahah.kd_transaksi_murabahah', $id)->first();
                $ModelJualBeliKedua = BankPermintaanBarangMurabahah::where('kd_transaksi_murabahah', $ModelJualBeliAwal->id)->first();
                $data = [
                    'kd_transaksi_murabahah'    => $ModelJualBeliAwal->kd_transaksi_murabahah,
                    'nama_barang'               => $ModelJualBeliKedua->nama_barang,
                    'jumlah_angsuran'           => $ModelJualBeliAwal->jumlah_angsuran,
                    'frekuensi_angsuran'        => $ModelJualBeliAwal->frekuensi_angsuran,
                    'angsuran_perbulan'         => $ModelJualBeliAwal->jumlah_angsuran / $ModelJualBeliAwal->frekuensi_angsuran
                ];

                return response()->json([
                    'status'        => 'true',
                    'message'       => 'Angsuran Pertama',
                    'data'          => $data
                ]);
            }

            return response()->json([
                'data'              => $ModelAngsuran,
                'status'            => 200
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function insertAngsuranMurabahah(Request $re)
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

            $tipe_transaksi = $re->angsuran_pertama;

            $CariTransaksi = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $re->kd_transaksi_murabahah)->first();

            if(empty($CariTransaksi))
            {
                return response()->json([
                    'message'       => 'Transaksi tidak ditemukan'
                ]);
            }

            $CountAngsuranAll  = BankJualBeliMurabahahAngsuran::count();
            $KalkulasiAngsuran = $CountAngsuranAll + 1;

            if($tipe_transaksi == true)
            {
                $ModelAngsuran      = new BankJualBeliMurabahahAngsuran;
                $ModelAngsuran->kd_angsuran_murabahah   = 'JB-MA-' . Carbon::now()->format('Y-m-d') . $KalkulasiAngsuran;
                $ModelAngsuran->kd_transaksi_murabahah  = $re->kd_transaksi_murabahah;
                $ModelAngsuran->tgl_bayar_angsuran      = Carbon::now();
                $ModelAngsuran->angsuran_ke             = 1;
                $ModelAngsuran->nominal_bayar           = $re->angsuran_perbulan;
                $ModelAngsuran->sisa_angsuran           = $re->frekuensi_angsuran - 1;
                $ModelAngsuran->kd_admin                = $kodeadmin;
                $ModelAngsuran->save();

                return response()->json([
                    'message'       => 'Angsuran Pertama berhasil disimpan'
                ]);
            } else if($tipe_transaksi == false)
            {
                $HitungAngsuran = BankJualBeliMurabahahAngsuran::where('kd_transaksi_murabahah', $re->kd_transaksi_murabahah)->count();

                $Kalkulasi      = $HitungAngsuran + 1;
                $SisaAngsuran   = $re->frekuensi_angsuran - $Kalkulasi;

                $ModelAngsuranAda = new BankJualBeliMurabahahAngsuran;
                $ModelAngsuranAda->kd_angsuran_murabahah   = 'JB-MA-' . Carbon::now()->format('Y-m-d') . $KalkulasiAngsuran;
                $ModelAngsuranAda->kd_transaksi_murabahah  = $re->kd_transaksi_murabahah;
                $ModelAngsuranAda->tgl_bayar_angsuran      = Carbon::now();
                $ModelAngsuranAda->angsuran_ke             = $Kalkulasi;
                $ModelAngsuranAda->nominal_bayar           = $re->angsuran_perbulan;
                $ModelAngsuranAda->sisa_angsuran           = $SisaAngsuran;
                $ModelAngsuranAda->kd_admin                = $kodeadmin;
                $ModelAngsuranAda->save();
                
                if($SisaAngsuran == 0)
                {
                    $ModelJualBeliMurabahah = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $re->kd_transaksi_murabahah)->first();
                    $ModelJualBeliMurabahah->status_transaksi = 'pass';
                    $ModelJualBeliMurabahah->save();

                    return response()->json(['Angsuran berhasil disimpan dan sudah lunas']);
                }
                
                return response()->json([
                    'message'       => 'Angsuran berhasil disimpan'
                ]);

            } else {
                return response('403 Forbidden', 403);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error',
                'message'   => 'Server Error'
            ]);
        }
    }
    
}
