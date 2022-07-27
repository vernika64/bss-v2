<?php

namespace App\Http\Controllers;

use App\Models\BankJualBeliMurabahah;
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
}
