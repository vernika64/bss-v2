<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use App\Models\SysProdukTabungan;
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
    
    public function insertDataTabungan(Request $re)
    {
        try {

            $kodebank   = 200;
            $kdbank     = 1;
            $kdadmin    = 1;

            $hitungtabungan = BankBukuTabunganWadiah::count() + 1;

            $formatbukutabungan = $kodebank . '-' . Carbon::now()->format('Y-m-d') . '-' . $hitungtabungan;

            $ModelBankBukuTabunganWadiah                        = new BankBukuTabunganWadiah;
            $ModelBankBukuTabunganWadiah->kd_produk_tabungan    = $re->kd_produk_tabungan;
            $ModelBankBukuTabunganWadiah->kd_buku_tabungan      = $formatbukutabungan;
            $ModelBankBukuTabunganWadiah->kd_cif                = $re->kd_cif;
            $ModelBankBukuTabunganWadiah->kd_bank               = $kdbank;
            $ModelBankBukuTabunganWadiah->total_nilai           = 0;
            $ModelBankBukuTabunganWadiah->kd_admin              = $kdadmin;
            $ModelBankBukuTabunganWadiah->save();

            return response()->json([
                'status'        => 'insertdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }
}
