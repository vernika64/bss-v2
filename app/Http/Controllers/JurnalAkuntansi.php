<?php

namespace App\Http\Controllers;

use App\Models\SysBank;
use App\Models\SysBukuAkuntansi;
use App\Models\SysBukuJurnalUmum;
use App\Models\SysBukuJurnalUmumDetail;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JurnalAkuntansi extends Controller
{

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
            $ModelJurnalUmumDetail = SysBukuJurnalUmumDetail::where('kd_transaksi_akuntansi', $id)->get();

            if(empty($ModelJurnalUmum))
            {
                return response('500 Internal Server Error <br>', 500);
            }

            return response()->json([
                'data'      => $ModelJurnalUmumDetail,
                'status'    => true
            ]);

        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }
}
