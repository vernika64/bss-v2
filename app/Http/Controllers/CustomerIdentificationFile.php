<?php

namespace App\Http\Controllers;

use App\Models\BankCIF;
use Illuminate\Http\Request;

class CustomerIdentificationFile extends Controller
{
    public function getDataCIF()
    {
        try {
            $ModelCIF = BankCIF::get();

            return response()->json([
                'data'      => $ModelCIF,
                'status'    => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }

    public function getDataCIFForTabel()
    {
        try {
            $ModelCIF = BankCIF::get(['kd_identitas', 'nama_sesuai_identitas', 'created_at']);

            return response()->json([
                'data'      => $ModelCIF,
                'status'    => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }



    public function insertDataCIF(Request $re)
    {
        try {
            $ModelCIF = new BankCIF;

            $ModelCIF->kd_identitas                 = $re->kd_identitas;
            $ModelCIF->tipe_id                      = $re->kd_tipe;
            $ModelCIF->nama_sesuai_identitas        = $re->nama;
            $ModelCIF->tempat_lahir                 = $re->tempat_lahir;
            $ModelCIF->tgl_lahir                    = $re->tgl_lahir;
            $ModelCIF->jenis_kelamin                = $re->jenis_kelamin;
            $ModelCIF->status_kawin                 = $re->status_kawin;
            $ModelCIF->kewarganegaraan              = $re->negara;
            $ModelCIF->alamat_sekarang              = $re->alamat;
            $ModelCIF->rt_rw                        = $re->rt_rw;
            $ModelCIF->desa_kelurahan               = $re->desa_kelurahan;
            $ModelCIF->kecamatan                    = $re->kecamatan;
            $ModelCIF->kabupaten_kota               = $re->kabupaten_kota;
            $ModelCIF->provinsi                     = $re->provinsi;
            $ModelCIF->kode_pos                     = $re->kode_pos;
            $ModelCIF->no_telp                      = $re->no_telp;
            $ModelCIF->email                        = $re->email;
            $ModelCIF->nama_ibu_kandung             = $re->nama_ibu;
            $ModelCIF->status_pekerjaan             = $re->status_pekerjaan;
            $ModelCIF->kd_user                      = '1';
            $ModelCIF->kd_bank                      = '1';
            $ModelCIF->save();

            return response()->json([
                'status'    => 'insertdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }
}
