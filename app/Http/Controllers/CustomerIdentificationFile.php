<?php

namespace App\Http\Controllers;

use App\Models\BankCIF;
use App\Models\SysToken;
use App\Models\SysUser;
use Illuminate\Http\Request;

class CustomerIdentificationFile extends Controller
{
    public function getDataCIF(Request $re)
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
                return response('Error 403 - Forbidden', 403);
            }

            $ModelCIF = BankCIF::where('kd_bank', $ModelUser->kd_bank)->get(['id', 'kd_identitas', 'nama_sesuai_identitas']);

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

    public function getDataCIFByIdForMurabahah($id, Request $re)
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
                return response('Error 403 - Forbidden', 403);
            }

            $ModelCIF = BankCIF::find($id);

            if(empty($ModelCIF))
            {
                return response('Error 404 - Data tidak ditemukan', 404);
            }

            return response()->json([
                'status'                        => 'getdata_success',
                'nama_sesuai_identitas'         => $ModelCIF->nama_sesuai_identitas
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }

    public function getDataCIFForTabel(Request $re)
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
                return response('Error 403 - Forbidden', 403);
            }

            $ModelCIF = BankCIF::where('kd_bank', $ModelUser->kd_bank)->get(['id', 'kd_identitas', 'nama_sesuai_identitas', 'created_at']);

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

    public function getDataCIFById($id, Request $re)
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
                return response('Error 403 - Forbidden', 403);
            }

            $ModelCIF = BankCIF::find($id);

            if(empty($ModelCIF)) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Data CIF tersedia',
                'data'      => $ModelCIF
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false,
                'message'   => 'Server error'
            ]);
        }
    }

    public function insertDataCIF(Request $re)
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
                return response('Error 403 - Forbidden', 403);
            }

            $cekidentitas   = BankCIF::where([
                'tipe_id'       => $re->kd_tipe,
                'kd_identitas'  => $re->kd_identitas
            ])->count();

            if($cekidentitas != 0)
            {
                return response()->json([
                    'message'       => 'CIF tidak bisa disimpan, Kode Identitas Sudah Terdaftar di sistem',
                    'status'        => false
                ]);
            }

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
            $ModelCIF->kd_user                      = $ModelUser->id;
            $ModelCIF->kd_bank                      = $ModelUser->kd_bank;
            $ModelCIF->save();

            return response()->json([
                'status'    => true,
                'message'   => 'CIF atasnama ' . $re->nama . ' berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'       => $th->getMessage(),
                'message'    => 'Server Error!',
                'status'       => false
            ]);
        }
    }
}
