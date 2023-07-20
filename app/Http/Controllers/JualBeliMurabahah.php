<?php

namespace App\Http\Controllers;

use App\Models\BankCIF;
use App\Models\BankJualBeliMurabahah;
use App\Models\BankJualBeliMurabahahAngsuran;
use App\Models\BankPermintaanBarangMurabahah;
use App\Models\SysBank;
use App\Models\SysBukuAkuntansi;
use App\Models\SysBukuJurnalUmum;
use App\Models\SysBukuJurnalUmumDetail;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class JualBeliMurabahah extends Controller
{
    protected $JurnalAkuntansi;

    protected $CountJurnalUmum;
    protected $CountJurnalUmumDetail;

    protected $JurnalUmumDetail;
    
    public function __construct(JurnalAkuntansi $jurnalakuntansi) {
        $this->JurnalAkuntansi = $jurnalakuntansi;
        
        $this->CountJurnalUmum          = SysBukuJurnalUmum::count();
        $this->CountJurnalUmumDetail    = SysBukuJurnalUmumDetail::count();

        $this->JurnalUmumDetail         = new \App\Models\SysBukuJurnalUmumDetail;
    }

    public function getDataTransaksiMurabahah(Request $re)
    {
        try {

            $token = $re->cookie('tkn');

            $ModelUser      = new SysUser();

            $data_user      = $ModelUser->getInformasiUser($token);

            if($data_user->status == false)
            {
                return response()->json([
                    'status'        => 200,
                    'qr_status'     => false,
                    'message'       => 'User belum login, silahkan login terlebih dahulu',
                    'data'          => null
                ]);
            }

            $kd_user            = $data_user->user_id;
            $kd_bank            = $data_user->kd_bank;

            $ModelJualBeli = BankJualBeliMurabahah::where('bank_jualbeli_murabahah.kd_bank', $kd_bank)
                             ->join('bank_cif', 'bank_jualbeli_murabahah.kd_cif', '=', 'bank_cif.id')
                             ->get(['bank_jualbeli_murabahah.id','kd_transaksi_murabahah', 'nama_sesuai_identitas', 'nama_permintaan', 'status_transaksi']);

            if(empty($ModelJualBeli))
            {
                return response()->json([
                    'status'        => 200,
                    'qr_status'     => false,
                    'message'       => 'Data kosong',
                    'data'          => null
                ]);
            }

            return response()->json([
                'status'        => 200,
                'qr_status'     => true,
                'message'       => 'Data berhasil diambil',
                'data'          => $ModelJualBeli
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

    public function getDataTransaksiMurabahahForTabel($id, Request $re)
    {
        try {

            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();
            $ModelBank = $ModelUser->kd_bank;

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $CariData = BankJualBeliMurabahah::where(['kd_transaksi_murabahah' => $id])->first();
            
            if(empty($CariData))
            {
                return response()->json([
                    'message'   => 'Data tidak ditemukan',
                    'status'    => false
                ]);
            } else if($CariData->kd_bank != $ModelBank)
            {
                return response()->json([
                    'message'   => 'Data ditemukan namun terdaftar di bank lain',
                    'status'    => false
                ]);
            }

            $CariDataNasabah    = BankCIF::find($CariData->kd_cif);

            if(empty($CariDataNasabah))
            {
                return response()->json([
                    'message'   => 'Data nasabah tidak ditemukan',
                    'status'    => false
                ]);
            }
            
            return response()->json([
                'data'      => [[
                    'kd_transaksi_murabahah'    => $CariData->kd_transaksi_murabahah,
                    'nama_sesuai_identitas'     => $CariDataNasabah->nama_sesuai_identitas,
                    'nama_permintaan'           => $CariData->nama_permintaan,
                    'status_transaksi'          => $CariData->status_transaksi
                    ]],
                'status'    => true
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
            $token  = $re->cookie('tkn');

            $ModelUser      = new SysUser();
            
            $data_user      = $ModelUser->getInformasiUser($token);

            if($data_user->status == false) {
                return response()->json([
                    'status'    => 200,
                    'qr_status' => false,
                    'message'   => 'User belum login, silahkan login terlebih dahulu',
                    'data'      => null  
                ]);
            }

            $kodebank  = $data_user->user_id;
            $kodeadmin = $data_user->kd_bank;

            // Input yang dibutuhkan dari user admin
            $counttransaksi     = BankJualBeliMurabahah::count();
            $countadd           = $counttransaksi + 1;

            $data_nasabah  = BankCIF::where(['kd_identitas' => $re->kd_identitas])->first();
            // Input yang dibutuhkan dari form

            $data                     = new stdClass;
            $data->kd_identitas       = $data_nasabah->id;
            $data->judul_permintaan   = $re->nama_permintaan;
            $data->deskripsi          = $re->deskripsi_permintaan;
            $data->link               = $re->link_pendukung;
            $data->status             = 'pending';                    // Pertama kali status dipending dahulu untuk diverifikasi oleh petugas back office
            
            $ModelJualBeli              = new BankJualBeliMurabahah;
            $ModelJualBeli->kd_transaksi_murabahah      = 'JB-MB-' . Carbon::now()->format('Y-m-d') . '-' .$countadd;
            $ModelJualBeli->tanggal_transaksi_murabahah = Carbon::now();
            $ModelJualBeli->kd_bank                     = $kodebank;
            $ModelJualBeli->kd_cif                      = $data->kd_identitas;
            $ModelJualBeli->nama_permintaan             = $data->judul_permintaan;
            $ModelJualBeli->deskripsi_permintaan        = $data->deskripsi;
            $ModelJualBeli->link_lampiran               = $data->link;
            $ModelJualBeli->status_transaksi            = $data->status;
            $ModelJualBeli->status_admin_pembuat        = $kodeadmin;
            $ModelJualBeli->save();
            
            return response()->json([
                'status'        => 200,
                'qr_status'     => true,
                'message'       => 'Permintaan berhasil ditambahkan',
                'data'          => null
            ]);
        } catch (\Throwable $th) {
            $err = new MetodeBerguna();
            return response()->json($err->outErrCatch($th->getMessage()));
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
            $token = $re->cookie('tkn');

            $ModelUser      = new SysUser();
            $data_user      = $ModelUser->getInformasiUser($token);

            if($data_user->status == false)
            {
                return response()->json([
                    'status'                => 200,
                    'qc_status'             => false,
                    'message'               => 'User tidak ditemukan',
                    'data'                  => null 
                ]);
            }

            $kd_user                    = $data_user->user_id;
            $kd_bank                    = $data_user->kd_bank;
            $kdtransaksi                = $re->kd_transaksi_murabahah;

            $angsuran                   = $re->angsuran_per_bulan;
            $frekuensi                  = $re->frekuensi_angsuran;
            $hargabarangsatuan          = $re->harga_barang_satuan;
            $namabarang                 = $re->nama_barang;
            $kuantitas                  = $re->qty_barang;
            $tipekuantitas              = $re->qty_type;
            $surplus                    = $re->surplus_untuk_bank;
            $totalbiaya                 = $re->total_biaya_akad_murabahah;
            $totalhargabarang           = $re->total_harga_barang;
            $totaldp                    = $re->uang_muka;

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
            $ModelJualBeli->uang_muka               = $totaldp;
            $ModelJualBeli->frekuensi_angsuran      = $frekuensi;
            $ModelJualBeli->jumlah_angsuran         = $totalbiaya;
            $ModelJualBeli->surplus_murabahah       = $surplus;
            $ModelJualBeli->status_admin_acc        = $kd_user;
            $ModelJualBeli->status_transaksi        = 'active';
            $ModelJualBeli->save();
        
            $BuatPermintaanBarang = new BankPermintaanBarangMurabahah;
        
            $BuatPermintaanBarang->kd_transaksi_murabahah          = $kdtransaksi;
            $BuatPermintaanBarang->tgl_permintaan_barang_dibuat    = Carbon::now();
            $BuatPermintaanBarang->kd_bank                         = $kd_bank;
            $BuatPermintaanBarang->nama_barang                     = $namabarang;
            $BuatPermintaanBarang->harga_barang_satuan             = $hargabarangsatuan;
            $BuatPermintaanBarang->kuantitas_barang                = $kuantitas;
            $BuatPermintaanBarang->tipe_kuantitas                  = $tipekuantitas;
            $BuatPermintaanBarang->status_barang                   = 'pending';
            $BuatPermintaanBarang->kd_admin_buat                   = $kd_user;
            $BuatPermintaanBarang->save();

            // Tambahkan Pencatatan ke Jurnal Umum

            $hargabrgsatuan     = $re->harga_barang_satuan;
            $brgqty             = $re->qty_barang;
            $brgdp              = $re->uang_muka;
            $brgmargin          = $re->surplus_untuk_bank;

            $total_biaya        = ($hargabrgsatuan * $brgqty) + $brgmargin;

            // Buat Jurnal Untuk Pendanaan Barang Permintaan
            
            $count_jurnal_one           = SysBukuJurnalUmum::count() + 1;
            $kd_transaksi_pendanaan     = 'JB-MA' . '-' . Carbon::now()->format('Y-m-d') . '-' . $count_jurnal_one;
            $total_harga_barang         = $re->harga_barang_satuan * $re->qty_barang;
            
            $this->JurnalAkuntansi->insertJurnalUmum(
                $kd_transaksi_pendanaan,
                Carbon::now(),
                'Pendanaan Barang untuk Jual Beli Murabahah',
                $total_harga_barang,
                'Alokasi dana untuk pendanaan barang jual beli murabahah',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'debit',
                13202,
                $kd_transaksi_pendanaan,
                $total_harga_barang,
                'Tambah Credit untuk Pendanaan Barang Jual Beli Murabahah',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'kredit',
                11001,
                $kd_transaksi_pendanaan,
                $total_harga_barang,
                'Kurangi Credit Kas ke Aset Pendanaan Barang Jual Beli Murabahah',
                $kd_user,
                $kd_bank
            );
            
            // Untuk Penerimaan Uang Muka
            
            $count_jurnal_two               = SysBukuJurnalUmum::count() + 1;
            $kd_transaksi_dp                = 'JB-MA' . '-' . Carbon::now()->format('Y-m-d') . '-' . $count_jurnal_two;

            $this->JurnalAkuntansi->insertJurnalUmum(
                $kd_transaksi_dp,
                Carbon::now(),
                'Terima Credit Dari bayar DP Jual Beli Murabahah',
                $re->uang_muka,
                'Terima Credit Dari bayar DP Jual Beli Murabahah',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'debit',
                11001,
                $kd_transaksi_dp,
                $re->uang_muka,
                'Tambah penghasilan dari pembayaran uang muka produk jual beli murabahah',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'kredit',
                11003,
                $kd_transaksi_dp,
                $re->uang_muka,
                'Kurangi Credit',
                $kd_user,
                $kd_bank
            );

            // Untuk Pengukuhan Akad
            
            $count_jurnal_three                      = SysBukuJurnalUmum::count() + 1;
            $kd_transaksi_pengukuhan                 = 'JB-MA' . '-' . Carbon::now()->format('Y-m-d') . '-' . $count_jurnal_three;
            $total_biaya_pengukuhan                  = ($hargabrgsatuan * $brgqty) + $brgmargin + $re->uang_muka;
            
            $this->JurnalAkuntansi->insertJurnalUmum(
                $kd_transaksi_pengukuhan, 
                Carbon::now(), 
                'Pengukuhan Akad Murabahah', 
                $total_biaya_pengukuhan,
                'Pengukuhan transaksi jual beli akad murabahah', 
                $kd_user, 
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'debit', 
                13201, 
                $kd_transaksi_pengukuhan, 
                $total_biaya, 
                'Tambah Credit Piutang Murabahah', 
                $kd_user, 
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'kredit', 
                11002, 
                $kd_transaksi_pengukuhan, 
                $re->surplus_untuk_bank, 
                'Pindah marjin keuntungan ke Piutang Murabahah', 
                $kd_user, 
                $kd_bank
            );

            $sumhargabarang = $re->harga_barang_satuan * $re->qty_barang;

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'kredit',
                13202,
                $kd_transaksi_pengukuhan,
                $sumhargabarang,
                'Alokasikan dana ke Piutang Murabahah',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'debit',
                11003,
                $kd_transaksi_pengukuhan,
                $re->uang_muka,
                'Impaskan uang muka yang sudah dipindah ke kas sebelumnya',
                $kd_user,
                $kd_bank
            );

            $this->JurnalAkuntansi->insertJurnalUmumDetail(
                'kredit',
                13201,
                $kd_transaksi_pengukuhan,
                $re->uang_muka,
                'Potongan dari Uang Muka',
                $kd_user,
                $kd_bank
            );

            return response()->json([
                'status'        => 200,
                'qr_status'     => true,
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
            $token = $re->cookie('tkn');

            $ModelUser      = new SysUser();
            $data_user      = $ModelUser->getInformasiUser($token);

            $kd_user        = $data_user->user_id;
            $kd_bank        = $data_user->kd_bank;

            $ModelJualBeli  = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $id)->first();
            
            if(empty($ModelJualBeli)) {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'Transaksi murabahah tidak ditemukan'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'pending') {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'Transaksi masih belum diverifikasi'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'pass') {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'Transaksi sudah lunas'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'fail') {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'Transaksi sudah diverifikasi gagal bayar'
                ]);
            } elseif($ModelJualBeli->status_transaksi == 'reject') {
                return response()->json([
                    'status'        => 200,
                    'message'       => 'Transaksi tidak lolos verifikasi'
                ]);
            }

            $ModelAngsuran = BankJualBeliMurabahahAngsuran::where('kd_transaksi_murabahah', $id)->count();

            if(empty($ModelAngsuran))
            {
                $ModelJualBeliAwal  = BankJualBeliMurabahah::where('bank_jualbeli_murabahah.kd_transaksi_murabahah', $id)->first();
                $ModelJualBeliKedua = BankPermintaanBarangMurabahah::where('kd_transaksi_murabahah', $ModelJualBeliAwal->id)->first();

                $SelisihAngsuran    = $ModelJualBeliAwal->jumlah_angsuran - $ModelJualBeliAwal->uang_muka;
                $HitungAngsuran     = $SelisihAngsuran / $ModelJualBeliAwal->frekuensi_angsuran;

                $data = [
                    'kd_transaksi_murabahah'    => $ModelJualBeliAwal->kd_transaksi_murabahah,
                    'nama_barang'               => $ModelJualBeliKedua->nama_barang,
                    'total_biaya_jual_beli'     => $ModelJualBeli->jumlah_angsuran,
                    'jumlah_angsuran'           => $SelisihAngsuran,
                    'frekuensi_angsuran'        => $ModelJualBeliAwal->frekuensi_angsuran,
                    'angsuran_perbulan'         => $HitungAngsuran
                ];

                return response()->json([
                    'status'                => 200,
                    'qr_status'             => true,
                    'message'               => 'Angsuran Pertama',
                    'data'                  => $data,
                    'jenis_angsuran'        => 'baru'
                ]);
            }

            $pencarian          = ['kd_transaksi_murabahah' => $id];

            $ModelJB1           = BankJualBeliMurabahah::where($pencarian)->first();
            $GetJB1ID           = $ModelJB1->id;
            $ModelJBPersediaan  = BankPermintaanBarangMurabahah::where(['kd_transaksi_murabahah' => $GetJB1ID])->first();

            $CountAngsuranById  = BankJualBeliMurabahahAngsuran::where($pencarian)->get()->count();

            $sisa_angsuran      = $ModelJB1->frekuensi_angsuran - $CountAngsuranById;

            $ModelJB2           = BankJualBeliMurabahah::where('bank_jualbeli_murabahah.kd_transaksi_murabahah', $id)
                                    ->join('bank_permintaan_barang_murabahah', 'bank_jualbeli_murabahah.id', '=', 'bank_permintaan_barang_murabahah.kd_transaksi_murabahah')
                                    ->get(['bank_jualbeli_murabahah.kd_transaksi_murabahah', 'nama_barang', 'status_transaksi']);

            
            $jumlah_angsuran         = $ModelJB1->jumlah_angsuran - $ModelJB1->uang_muka;
            $angsuran_bulanan        = $jumlah_angsuran / $ModelJB1->frekuensi_angsuran;
            $total_angsuran          = $angsuran_bulanan * $CountAngsuranById;
            $sisa_angsuran_jb        = $jumlah_angsuran - $total_angsuran;
            $sisa_frekuensi_angsuran = $ModelJB1->frekuensi_angsuran - $CountAngsuranById;
            // $angsuran_bulanan        = ((($ModelJB1->harga_barang_satuan * $ModelJB1->frekuensi_angsuran) + $ModelJB1->surplus_murabahah) - $ModelJB1->uang_muka) / $ModelJB1->frekuensi_angsuran;

            $DataUntukForm = [
                'kd_transaksi_murabahah'    => $ModelJB1->kd_transaksi_murabahah,
                'nama_barang'               => $ModelJBPersediaan->nama_barang,
                'jumlah_angsuran'           => $sisa_angsuran_jb,
                'jumlah_transaksi'          => $ModelJB1->jumlah_angsuran,
                'total_frekuensi_angsuran'  => $ModelJB1->frekuensi_angsuran,
                'sisa_frekuensi_angsuran'   => $sisa_frekuensi_angsuran,
                'angsuran_perbulan'         => $angsuran_bulanan
            ];

            return response()->json([
                'status'             => 200,
                'qr_status'          => true,
                'data1'              => $ModelJB2,
                'data2'              => $DataUntukForm,
                'message'            => 'Data Angsuran berhasil diambil',
                'jenis_angsuran'     => 'lama'
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server Error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function ambilHistoriDataAngsuran($id, Request $re)
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

            $ModelAngsuran = BankJualBeliMurabahahAngsuran::where('bank_jualbeli_murabahah_angsuran.kd_transaksi_murabahah', $id)->get(['tgl_bayar_angsuran', 'nominal_bayar']);

            return response()->json([
                'data'      => $ModelAngsuran
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server Error',
                'message'   => 'Server Error'
            ]);
        }
    }

    public function insertAngsuranMurabahah(Request $re)
    {
        try {

            $token                      = $re->cookie('tkn');

            $ModelUser                  = new SysUser();
            $data_user                  = $ModelUser->getInformasiUser($token);

            $kodeadmin                  = $data_user->user_id;
            $kodebank                   = $data_user->kd_bank;


            $jenis_transaksi         = $re->jenis_angsuran;
            $kd_transaksi_jb            = $re->kd_transaksi_murabahah;

            $CariTransaksi              = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $kd_transaksi_jb)->first();

            if(empty($CariTransaksi))
            {
                return response()->json([
                    'message'       => 'Transaksi tidak ditemukan'
                ]);
            }

            $CountAngsuranAll  = BankJualBeliMurabahahAngsuran::count();
            $KalkulasiAngsuran = $CountAngsuranAll + 1;

            if($jenis_transaksi == 'baru')
            {
                $query_pencarian_jb = ['kd_transaksi_murabahah' => $kd_transaksi_jb];

                $ModelJB            = BankJualBeliMurabahah::where($query_pencarian_jb)->first();
                
                if(empty($ModelJB)) {
                    return response()->json([
                        'status'        => 200,
                        'qr_status'     => false,
                        'message'       => 'Kode Transaksi Jual Beli Murabahah tidak ditemukan'
                    ]);
                }

                $total_angsuran     = $ModelJB->jumlah_angsuran - $ModelJB->uang_muka;
                $frekuensi_angsuran = $ModelJB->frekuensi_angsuran;

                $data_jb                        = new stdClass;
                $data_jb->angsuran_pertama      = $total_angsuran / $frekuensi_angsuran;
                $data_jb->sisa_angsuran         = $frekuensi_angsuran - 1;

                $ModelAngsuran                          = new BankJualBeliMurabahahAngsuran;
                $ModelAngsuran->kd_angsuran_murabahah   = 'JB-MA-' . Carbon::now()->format('Y-m-d') . $KalkulasiAngsuran;
                $ModelAngsuran->kd_transaksi_murabahah  = $kd_transaksi_jb;
                $ModelAngsuran->tgl_bayar_angsuran      = Carbon::now();
                $ModelAngsuran->angsuran_ke             = 1;
                $ModelAngsuran->nominal_bayar           = $data_jb->angsuran_pertama;
                $ModelAngsuran->sisa_angsuran           = $data_jb->sisa_angsuran;
                $ModelAngsuran->kd_admin                = $kodeadmin;
                $ModelAngsuran->save();

                // Untuk Pencatatan di Jurnal Umum
                
                $HitungJumlahJurnalUmum     = $this->CountJurnalUmum + 1;
                
                $jurnal_kd_transaksi       = 'JB-MA' . '-' . Carbon::now()->format('Y-m-d') . '-' . $HitungJumlahJurnalUmum;
                $jurnal_tgl_pencatatan     = Carbon::now();
                $jurnal_nama_transaksi     = 'Angsuran Pertama Produk Jual Beli Akad Murabahah dengan kode transaksi : ' . $re->kd_transaksi_murabahah;
                $jurnal_nilai_transaksi    = $data_jb->angsuran_pertama;
                $jurnal_deskripsi          = 'Angsuran Produk Jual Beli Akad Murabahah';

                $this->JurnalAkuntansi->insertJurnalUmum(
                    $jurnal_kd_transaksi, 
                    $jurnal_tgl_pencatatan, 
                    $jurnal_nama_transaksi, 
                    $jurnal_nilai_transaksi, 
                    $jurnal_deskripsi, 
                    $kodeadmin, 
                    $kodebank);

                $this->JurnalAkuntansi->insertJurnalUmumDetail(
                    'debit', 
                    11001, 
                    $jurnal_kd_transaksi, 
                    $jurnal_nilai_transaksi, 
                    'Pendapatan dari Angsuran Produk Jual Beli Murabahah', 
                    $kodeadmin, 
                    $kodebank
                );

                $this->JurnalAkuntansi->insertJurnalUmumDetail(
                    'kredit', 
                    13201, 
                    $jurnal_kd_transaksi, 
                    $jurnal_nilai_transaksi, 
                    'Piutang Murabahah dialokasikan ke Kas', 
                    $kodeadmin, 
                    $kodebank
                );

                return response()->json([
                    'status'        => 200,
                    'qr_status'     => true,
                    'message'       => 'Angsuran Pertama berhasil disimpan'
                ]);

            } else if($jenis_transaksi == 'lama')
            {
                $query_pencarian        = ['kd_transaksi_murabahah' => $kd_transaksi_jb];

                $ModelJB                = BankJualBeliMurabahah::where($query_pencarian)->first();

                if(empty($ModelJB)) {
                    return response()->json([
                        'status'        => 200,
                        'qr_status'     => false,
                        'message'       => 'Kode Transaksi Jual Beli Murabahah tidak ditemukan'
                    ]);
                }

                $total_angsuran     = $ModelJB->jumlah_angsuran - $ModelJB->uang_muka;
                $frekuensi_angsuran = $ModelJB->frekuensi_angsuran;

                $HitungAngsuran = BankJualBeliMurabahahAngsuran::where('kd_transaksi_murabahah', $re->kd_transaksi_murabahah)->count();

                $angsuran_perbulan              = $total_angsuran / $frekuensi_angsuran;

                $data_jb                        = new stdClass;
                $data_jb->angsuran_perbulan     = $angsuran_perbulan;
                $data_jb->sisa_angsuran         = $total_angsuran - $angsuran_perbulan; 

                $kalkulasi      = $HitungAngsuran + 1;
                $sisaAngsuran   = $frekuensi_angsuran - $kalkulasi;

                $ModelAngsuranAda = new BankJualBeliMurabahahAngsuran;
                $ModelAngsuranAda->kd_angsuran_murabahah   = 'JB-MA-' . Carbon::now()->format('Y-m-d') . $KalkulasiAngsuran;
                $ModelAngsuranAda->kd_transaksi_murabahah  = $kd_transaksi_jb;
                $ModelAngsuranAda->tgl_bayar_angsuran      = Carbon::now();
                $ModelAngsuranAda->angsuran_ke             = $kalkulasi;
                $ModelAngsuranAda->nominal_bayar           = $data_jb->angsuran_perbulan;
                $ModelAngsuranAda->sisa_angsuran           = $sisaAngsuran;
                $ModelAngsuranAda->kd_admin                = $kodeadmin;
                $ModelAngsuranAda->save();
                
                // Untuk Pencatatan di Jurnal Umum
                
                $HitungJumlahJurnalUmum     = $this->CountJurnalUmum + 1;
                
                $ju_kd_transaksi           = 'JB-MA' . '-' . Carbon::now()->format('Y-m-d') . '-' . $HitungJumlahJurnalUmum;
                $ju_tgl_pencatatan         = Carbon::now();
                $ju_nama_transaksi         = 'Angsuran Produk Jual Beli Akad Murabahah dengan kode transaksi : ' . $re->kd_transaksi_murabahah;
                $ju_nilai_transaksi        = $data_jb->angsuran_perbulan;
                $ju_deskripsi              = 'Angsuran Produk Jual Beli Akad Murabahah';

                $this->JurnalAkuntansi->insertJurnalUmum(
                    $ju_kd_transaksi, 
                    $ju_tgl_pencatatan, 
                    $ju_nama_transaksi, 
                    $ju_nilai_transaksi, 
                    $ju_deskripsi, 
                    $kodeadmin, 
                    $kodebank
                );

                $this->JurnalAkuntansi->insertJurnalUmumDetail(
                    'debit', 
                    11002, 
                    $ju_kd_transaksi, 
                    $ju_nilai_transaksi, 
                    'Debet dari Piutang Murabahah', 
                    $kodeadmin, 
                    $kodebank
                );

                $this->JurnalAkuntansi->insertJurnalUmumDetail(
                    'kredit',
                    13201, 
                    $ju_kd_transaksi,
                    $ju_nilai_transaksi, 
                    'Kredit ke Kas Penjualan Produk JB Murabahah', 
                    $kodeadmin, 
                    $kodebank
                );

                if($sisaAngsuran == 0)
                {
                    $ModelJualBeliMurabahah = BankJualBeliMurabahah::where('kd_transaksi_murabahah', $re->kd_transaksi_murabahah)->first();
                    $ModelJualBeliMurabahah->status_transaksi = 'pass';
                    $ModelJualBeliMurabahah->save();

                    return response()->json([
                        'status'        => 200,
                        'qr_status'     => true,
                        'message'       => 'Angsuran berhasil disimpan dan sudah lunas',
                    ]);
                }
                
                return response()->json([
                    'status'        => 200,
                    'qr_status'     => true,
                    'message'       => 'Angsuran berhasil disimpan'
                ]);

            } else {
                return response()->json([
                    'status'        => 200,
                    'qr_status'     => false,
                    'message'       => 'Terjadi kesalahan saat menyimpan transaksi'
                ]);
            }
        } catch (\Throwable $th) {
            $err = new MetodeBerguna();
            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }
    
}
