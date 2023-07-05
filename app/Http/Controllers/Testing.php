<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use Illuminate\Http\Request;
use stdClass;

class Testing extends Controller
{
    public function tesCookie(Request $re)
    {
        try {
            if (empty($re->cookie('tkn'))) {
                return response()->json([
                    'status'    => 'Cookie Doesnt Exist'
                ]);
            }

            return response()->json([
                'status'    => 'Cookie Exist'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }

    function tescaridatatabungan(Request $re) {
        try {
            $data                           = new stdClass;
            $data->kd_cif                   = $re->kd_cif;
            $data->kd_produk_tabungan       = $re->kd_produk_tabungan;

            $ModelTabungan                  = new BankBukuTabunganWadiah();
            $hasilPencarian                 = $ModelTabungan->cariDataTabunganNasabah($data);

            if($hasilPencarian->status == true) {
                return response()->json([
                    'status'            => 200,
                    'message'           => $hasilPencarian->message
                ]);
            } else if($hasilPencarian->status == false) {
                return response()->json([
                    'status'            => 200,
                    'message'           => $hasilPencarian->message
                ]);
            }

        } catch (\Throwable $th) {
            $MetodeBerguna      = new MetodeBerguna;
            
            return response()->json($MetodeBerguna->outErrCatch($th->getMessage()));
        }
    }
}
