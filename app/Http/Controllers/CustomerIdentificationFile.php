<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MetodeBerguna;

use App\Models\BankCIF;
use App\Models\SysToken;
use App\Models\SysUser;
use Illuminate\Http\Request;
use stdClass;

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

    public function cekKetersediaanNomerId(Request $re) {
        try {
            $tipe_id            = $re->tipe_id;
            $nomer_id           = $re->nomer_id;

            $ModelCIF           = new BankCIF;
            $Hasil              = $ModelCIF->cariStatusID($tipe_id, $nomer_id, $re->cookie('tkn'));

            if($Hasil->status == true) {
                if($Hasil->count == 0) {
                    return response()->json([
                        'status'    => 202,
                        'message'   => 'Identitas tidak terdaftar'
                    ]);
                } else if($Hasil->count >= 1) {
                    return response()->json([
                        'status'    => 400,
                        'message'   => 'Identitas sudah terdaftar'
                    ]);
                }
            }

        } catch (\Throwable $th) {
            $ModelBerguna       = new MetodeBerguna;

            return response()->json($ModelBerguna->outErrCatch($th->getMessage()));
        }
    }

    public function insertDataCIF(Request $re)
    {
        try {

            $ModelUser      = new SysUser();
            $CariUser       = $ModelUser->getInformasiUser($re->cookie('tkn'));
            
            if($CariUser->status == true) {
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
                $ModelCIF->kd_user                      = $CariUser->user_id;
                $ModelCIF->kd_bank                      = $CariUser->kd_bank;
                $ModelCIF->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'CIF atas nama ' . $re->nama . ' berhasil disimpan'
                ]);
                
            } else {
                return response()->json([
                    'status'        => 500,
                    'message'       => 'Terjadi kesalahan di server'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data'       => $th->getMessage(),
                'message'    => 'Server Error!',
                'status'       => false
            ]);
        }
    }

    public function getNomorIdentitas(Request $re)
    {
        try {

            $auth = 'a';

            if($auth == false)
            {
                return response()->json([
                    'status'    => 403,
                    'message'   => 'Anda tidak memiliki hak akses ke url ini, silahkan login terlebih dahulu'
                ]);
            }

            $tipe       = $re->tipe;
            
            $nomerid    = $re->nomerid;

            $ModelCIF = BankCIF::where(['tipe_id' => $tipe, 'kd_identitas' => $nomerid])->first();

            if(!empty($ModelCIF))
            {
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Identitas sudah terdaftar',
                    'data'      => [
                        'nama'          => $ModelCIF->nama_sesuai_identitas,
                        'tipe_id'       => $ModelCIF->tipe_id,
                        'kd_identitas'  => $ModelCIF->kd_identitas
                    ]
                ]);
            }

            return response()->json([
                'status'    => 404,
                'message'   => 'Identitas belum terdaftar'
            ]);
            
        } catch (\Throwable $th) {
            $err = new MetodeBerguna();
            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }

    public function cekDataNasabah(Request $re)
    {
        try {

            $token  = $re->cookie('tkn');

            $auth   = new Auth();

            $output = $auth->loginCheck($token);

            if($output->status == false) {
                return "gatot";
            } else if($output->status == true) {
                dd($output);
            } else {
                return "server error";
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function cariDataNasabah(Request $re) {
        try {
            $token_user  = $re->cookie('tkn');

            $ModelUser  = new SysUser();
            $data_user   = $ModelUser->getInformasiUser($token_user);
            
            if($data_user->status == true) {
                $data_cif                       = new stdClass;
                $data_cif->tipe_id              = $re->tipe_id;
                $data_cif->kd_identitas         = $re->kd_identitas;
                $data_cif->kd_bank              = $data_user->kd_bank;

                $ModelCIF                       = new BankCIF();
                $hasil_cif                      = $ModelCIF->cariInfoCIFByIdDanBank($data_cif);

                if ($hasil_cif->status == true) {
                    return response()->json([
                        'data'              => $hasil_cif,
                        'message'           => 'Data berhasil diambil',
                        'status'            => 200,
                        'qr_status'         => true
                    ]);
                } else if($hasil_cif->status == false) {
                    return response()->json([
                        'status'            => 200,
                        'message'           => $hasil_cif->message,
                        'qr_status'         => false,
                        'tipe_id'           => $re->tipe_id,
                        'kd_identitas'      => $re->kd_identitas

                        // 'data'      => $hasil_cif->message,
                        // 'form'      => $data_cif
                    ]);
                }
            } 
        } catch (\Throwable $th) {
            $err = new MetodeBerguna();
            return response()->json($err->outErrCatch($th->getMessage()));
        }
    }
}
