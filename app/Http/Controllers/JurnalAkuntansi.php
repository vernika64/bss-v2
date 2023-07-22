<?php

namespace App\Http\Controllers;

use App\Models\BankBukuAkuntansi;
use App\Models\SysBank;
use App\Models\SysBukuAkuntansi;
use App\Models\SysBukuJurnalUmum;
use App\Models\SysBukuJurnalUmumDetail;
use App\Models\SysMasterBukuAkuntansi;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class JurnalAkuntansi extends Controller
{

    function tulisJurnalUmum($tipe_jurnal, $data) {
        try {

            if($tipe_jurnal == 'judul') {
                $kd_transaksi                            = $data->kd_transaksi;
                $tgl_pencatatan                          = $data->tgl_pencatatan;
                $nama_transaksi                          = $data->nama_transaksi;
                $nominal                                 = $data->nominal;
                $deskripsi                               = $data->deskripsi;
                $user_id                                 = $data->user_id;
                $kd_bank                                 = $data->kd_bank;

                $ModelJurnalUmum                         = new SysBukuJurnalUmum();
                $ModelJurnalUmum->kd_transaksi_akuntansi = $kd_transaksi;
                $ModelJurnalUmum->tgl_pencatatan_jurnal  = $tgl_pencatatan;
                $ModelJurnalUmum->nama_transaksi         = $nama_transaksi;
                $ModelJurnalUmum->nominal_transaksi      = $nominal;
                $ModelJurnalUmum->deskripsi              = $deskripsi;
                $ModelJurnalUmum->status_transaksi       = 'open';
                $ModelJurnalUmum->kd_admin               = $user_id;
                $ModelJurnalUmum->kd_bank                = $kd_bank;
                $ModelJurnalUmum->save();

                $output                     = new stdClass;
                $output->status             = true;
                $output->message            = 'Pencatatan berhasil disimpan';
                $output->data               = null;
            } else if($tipe_jurnal == 'detail') {
                
                $kd_transaksi                                       = $data->kd_transaksi;
                $buku_akuntansi                                     = $data->buku_akuntansi;
                $tipe_transaksi                                     = $data->tipe_transaksi;
                $nominal_transaksi                                  = $data->nominal_transaksi;
                $deskripsi                                          = $data->deskripsi;
                $user_id                                            = $data->user_id;
                $kd_bank                                            = $data->kd_bank;

                $ModelJurnalUmumDetail                              = new SysBukuJurnalUmumDetail;
                $ModelJurnalUmumDetail->kd_transaksi_akuntansi      = $kd_transaksi;
                $ModelJurnalUmumDetail->kd_buku_akuntansi           = $buku_akuntansi;
                if($tipe_transaksi == 'debit') {
                    $ModelJurnalUmumDetail->nominal_debit           = $nominal_transaksi;
                    $ModelJurnalUmumDetail->nominal_kredit          = 0;
                } elseif($tipe_transaksi == 'kredit') {
                    $ModelJurnalUmumDetail->nominal_debit           = 0;
                    $ModelJurnalUmumDetail->nominal_kredit          = $nominal_transaksi;
                }
                $ModelJurnalUmumDetail->deskripsi                   = $deskripsi;
                $ModelJurnalUmumDetail->kd_admin                    = $user_id;
                $ModelJurnalUmumDetail->kd_bank                     = $kd_bank;
                $ModelJurnalUmumDetail->save();

                $ModelJurnalUmumDetail->refresh();

                $output                                             = new stdClass;
                $output->status                                     = true;
                $output->message                                    = 'Pencatatan Detail berhasil disimpan';
                $output->data                                       = null;

            } else {
                $output                 = new stdClass;
                $output->status         = false;
                $output->message        = 'Parameter Input kategori jurnal tidak terdaftar';
                $output->data           = null;
            }

            return $output;

        } catch (\Throwable $th) {
            $output                     = new stdClass;
            $output->status             = false;
            $output->message            = 'Pencatatan gagal disimpan';
            $output->data               = $th->getMessage();

            return $output;
        }
    }

    public function insertJurnalUmum($kode_transaksi, $tanggal_pencatatan, $transaction_name, $cash, $desc, $userid, $bankid)
    {
        try {
            $ModelJurnalUmum                         = new SysBukuJurnalUmum;
            $ModelJurnalUmum->kd_transaksi_akuntansi = $kode_transaksi;
            $ModelJurnalUmum->tgl_pencatatan_jurnal  = $tanggal_pencatatan;
            $ModelJurnalUmum->nama_transaksi         = $transaction_name;
            $ModelJurnalUmum->nominal_transaksi      = $cash;
            $ModelJurnalUmum->deskripsi              = $desc;
            $ModelJurnalUmum->status_transaksi       = 'open';
            $ModelJurnalUmum->kd_admin               = $userid;
            $ModelJurnalUmum->kd_bank                = $bankid;
            return $ModelJurnalUmum->save();

        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }

    public function insertJurnalUmumDetail($tipe_transaksi, $buku_akuntansi, $kode_transaksi, $cash, $desc, $userid, $bankid)
    {
        try {
            $ModelJurnalUmumDetail                              = new SysBukuJurnalUmumDetail;
            $ModelJurnalUmumDetail->kd_transaksi_akuntansi      = $kode_transaksi;
            $ModelJurnalUmumDetail->kd_buku_akuntansi           = $buku_akuntansi;
            if($tipe_transaksi == 'debit') {
                $ModelJurnalUmumDetail->nominal_debit           = $cash;
                $ModelJurnalUmumDetail->nominal_kredit          = 0;
            } elseif($tipe_transaksi == 'kredit') {
                $ModelJurnalUmumDetail->nominal_debit           = 0;
                $ModelJurnalUmumDetail->nominal_kredit          = $cash;
            }
            $ModelJurnalUmumDetail->deskripsi                   = $desc;
            $ModelJurnalUmumDetail->kd_admin                    = $userid;
            $ModelJurnalUmumDetail->kd_bank                     = $bankid;
            $ModelJurnalUmumDetail->save();

            return $ModelJurnalUmumDetail->refresh();
        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }

    public function getDataJurnalAkuntansi(Request $re)
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

            $kodeadmin  = $ModelUser->id;
            $kodebank   = $ModelUser->kd_bank;

            $ModelJurnalUmum = SysBukuJurnalUmum::where('kd_bank', $kodebank)->get();

            if(empty($ModelJurnalUmum))
            {
                return response('500 Internal Server Error <br>', 500);
            }

            return response()->json([
                'data'      => $ModelJurnalUmum,
                'status'    => true
            ]);

        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }

    public function getDataJurnalAkuntansiDetail($id, Request $re)
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

            $kodeadmin  = $ModelUser->id;
            $kodebank   = $ModelUser->kd_bank;

            $ModelJurnalUmum = SysBukuJurnalUmum::where('kd_bank', $kodebank)->get();

            if(empty($ModelJurnalUmum))
            {
                return response('500 Internal Server Error <br>', 500);
            }

            $ModelJurnalUmumDetail = SysBukuJurnalUmumDetail::where('kd_transaksi_akuntansi', $id)->get();
            $DaftarJurnal          = [];
            foreach($ModelJurnalUmumDetail as $mju)
            {
                $ModelMasterJurnal = SysMasterBukuAkuntansi::where('kd_sub_master_buku', $mju['kd_buku_akuntansi'])->first();

                if(empty($ModelMasterJurnal))
                {
                    // No Action
                }

                $DataArray         = [
                    'kd_transaksi_akuntansi'    => $mju['kd_transaksi_akuntansi'],
                    'kd_buku_akuntansi'         => $mju['kd_buku_akuntansi'],
                    'nominal_debit'             => $mju['nominal_debit'],
                    'nominal_kredit'            => $mju['nominal_kredit'],
                    'deskripsi'                 => $mju['deskripsi'],
                    'kd_admin'                  => $mju['kd_admin'],
                    'kd_bank'                   => $mju['kd_bank'],
                    'nama_buku_akuntansi'       => $ModelMasterJurnal->nama_buku
                ];
                
                array_push($DaftarJurnal, $DataArray);
            }


            return response()->json([
                'data'      => $DaftarJurnal,
                'status'    => true
            ]);

        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }
}
