<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MetodeBerguna;

use App\Models\SysBank;
use App\Models\SysToken;
use App\Models\SysUser;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class Auth extends Controller
{
    public function login(Request $re)
    {
        try {
            $ModelUser = SysUser::where('username', $re->username)->first();
            if(empty($ModelUser)) {
                return response()->json([
                    'message'   => 'Akun tidak terdaftar',
                    'status'    => false
                ]);
            } else if(!Hash::check($re->password, $ModelUser->password)) {
                return response()->json([
                    'message'   => 'Password salah',
                    'status'    => false
                ]);
            } else if(!$ModelUser) {
                return response()->json([
                    'message'   => 'Terjadi kesalahan di server, silahkan coba lagi',
                    'status'    => false
                ]);
            }
            $ModelBank = SysBank::find($ModelUser->kd_bank);
            if(!empty($ModelBank)) {
                $data_cookie    = Hash::make(rand());

                $cookie         = cookie('tkn', $data_cookie, 3 * 60);

                $ModelToken             = new SysToken;
                $ModelToken->kd_user    = $ModelUser->username;
                $ModelToken->token      = $data_cookie;
                $ModelToken->save();

                return response()->json([
                    'status'    => true,
                    'message'   => 'Berhasil Login',
                    'role'      => $ModelUser->role,
                    'user'      => $ModelUser->username,
                    'nama'      => $ModelUser->fname
                ])->withCookie($cookie);
            } else {
                return response()->json([
                    'message'       => 'Terdapat kesalahan pada data user, mohon laporkan ke web admin untuk perbaikan',
                    'status'        => false
                ]);
            }
        } catch (\Throwable $th) {
            $out        = new MetodeBerguna();
            return response()->json($out->outErrCatch($th->getMessage()));
        }
    }

    public function appLevelLoginAuth(Request $re)
    {
        try {
            $ModelUser      = new SysUser();
            $User           = $ModelUser->getInformasiUser($re->cookie('tkn'));

            if($User->status == true) {
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diambil',
                    'role'      => $User->role
                ]);                
            } else {
                return response()->json([
                    'status'        => 404,
                    'message'       => 'Data tidak ditemukan'
                ]);
            }

        } catch (\Throwable $th) {
            $ModelBerguna = new MetodeBerguna;

            return response()->json($ModelBerguna->outErrCatch($th->getMessage()));
        }
    }

    public function logout(Request $re)
    {
        try {
            $kuki = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $kuki)->first();

            if(!$ModelToken) {
                return response()->json([
                    'status'        => '400',
                    'message'       => 'Token tidak ditemukan, proses logout sekarang'
                ]);
            }

            if(SysToken::where('token', $kuki)->delete())
            {
                return response()->json([ 'status' => 'logout_success'])->withoutCookie('tkn');
            } else {
                return response()->json([ 'status' => 'logout_error']);
            }
            
        } catch (\Throwable $th) {
            $ModelBerguna = new MetodeBerguna;

            return response()->json($ModelBerguna->outErrCatch($th->getMessage()));
        }
    }

    // GRAVEYARD

    public function checkSudahLogin(Request $re)
    {
        try {
            if(empty($re->cookie('tkn')))
            {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'Login token not found'
                ]);
            } else {
                $ModelToken = SysToken::where('token', $re->cookie('tkn'))->first();

                if(!$ModelToken) {
                    return response()->json([
                        'status'    => 403,
                        'message'   => 'Login token not registered in system'
                    ]);
                }

                $uname      = $ModelToken->kd_user; 

                $ModelUser  = SysUser::where('username', $uname)->first(); 

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Login token available',
                    'role'      => $ModelUser->role,
                    'isi'       => $ModelToken,
                ]);
            }
        } catch (\Throwable $th) {
            $ModelBerguna = new MetodeBerguna;

            return response()->json($ModelBerguna->outErrCatch($th->getMessage()));
        }
    }

    // Token lebih dari 3 jam (10800 detik) setelah dibuat = expired
    public function loginTokenCheck($token)
    {
        try {
            $ModelToken = SysToken::where(['token' => $token])->first();

            if(!empty($ModelToken)) {
                $ModelUser                  = SysUser::where('username', $ModelToken->kd_user)->first();
                
                if(!empty($ModelUser)) {
                    $token_dibuat               = $ModelToken->created_at;
                    $tanggal_token              = date('Y-m-d', $token_dibuat);
                    $tanggal_akses              = date('Y-m-d');
                    $waktu_token                = strtotime(date('H:i:s', $token_dibuat));
                    $waktu_akses                = strtotime(date('H:i:s'));
    
                    $tgl_akses                  = new DateTime($tanggal_akses);
                    $tgl_token                  = new DateTime($tanggal_token);
    
                    $beda_tanggal               = $tgl_akses->diff($tgl_token);
                    $beda_waktu                 = ($waktu_akses - $waktu_token) - 10800;
    
                    $interval_hari              = $beda_tanggal->d;
                    $interval_bulan             = $beda_tanggal->m;
                    $interval_tahun             = $beda_tanggal->y;
    
                    if($interval_hari == 0 && $interval_bulan == 0 && $interval_tahun == 0 && $beda_waktu > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (\Throwable $th) {
            $ModelBerguna = new MetodeBerguna;
            $ModelBerguna->outErrCatch($th->getMessage());
            
            return false;
        }
    }
}
