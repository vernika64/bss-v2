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
    protected $JModelUser;
    protected $JModelBank;
    // protected $JModelBukuAkuntansi;
    // protected $JModelJurnalUmum;
    // protected $JModelJurnalUmumDetail;
    protected $CountJurnalUmum;
    protected $CountJurnalUmumDetail;

    public function __construct() {
        $getusercookie = cookie('tkn');

        $ModelToken = SysToken::where('token', $getusercookie)->first();

        if(empty($ModelToken))
        {
            return response('Error 403 - Forbidden', 403);
        }

        $this->JModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

        if(empty($JModelUser))
        {
            return response('Error 403 - Forbidden', 403);
        }

        $this->JModelBank = SysBank::find($this->JModelUser->kd_bank);

        $this->CountJurnalUmum          = SysBukuJurnalUmum::count();
        $this->CountJurnalUmumDetail    = SysBukuJurnalUmumDetail::count();

    }

    public function insertJurnalUmum($status, $buku_akuntansi, $tgl_pencatatan, $nama_transaksi, $nominal_transaksi, $deskripsi)
    {
        try {
            $CariBukuAkuntansi = SysBukuAkuntansi::
                                 where([
                                    'kd_sub_master_buku' => $buku_akuntansi,
                                    'kd_bank'            => $this->JModelUser->kd_bank
                                 ])->first();

            if(empty($CariBukuAkuntansi))
            {
                return response('Error 403 - Forbidden dalam mencari buku akuntansi', 403);
            }

            $HitungJumlahJurnalUmum     = $this->CountJurnalUmum + 1;
            $FormatPenulisanJurnalUmum  = $buku_akuntansi . '-' . Carbon::now()->format('Y-m-d') . '-' . $HitungJumlahJurnalUmum;

            $ModelJurnalUmum    = new SysBukuJurnalUmum;
            $ModelJurnalUmum->kd_transaksi_akuntansi = $FormatPenulisanJurnalUmum;
            $ModelJurnalUmum->tgl_pencatatan_jurnal  = Carbon::now();
            $ModelJurnalUmum->nama_transaksi         = $nama_transaksi;
            $ModelJurnalUmum->nominal_transaksi      = $nominal_transaksi;
            $ModelJurnalUmum->deskripsi              = $deskripsi;
            $ModelJurnalUmum->kd_admin               = $this->JModelUser->id;
            $ModelJurnalUmum->kd_bank                = $this->JModelUser->kd_bank;
            $ModelJurnalUmum->save();

        } catch (\Throwable $th) {
            return response('500 Internal Server Error <br>' . $th->getMessage(), 500);
        }
    }
}
