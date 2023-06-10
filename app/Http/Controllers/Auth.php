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

            if(empty($ModelUser))
            {
                return response()->json([
                    'message'   => 'Akun tidak terdaftar',
                    'status'    => 404
                ]);
            } else if(!Hash::check($re->password, $ModelUser->password))
            {
                return response()->json([
                    'message'   => 'Password salah',
                    'status'    => 400
                ]);
            } else if(!$ModelUser) {
                return response()->json([
                    'message'   => 'Terjadi kesalahan di server, silahkan coba lagi',
                    'status'    => 500
                ]);
            }

            $ModelBank = SysBank::find($ModelUser->kd_bank);
            if(empty($ModelBank))
            {
                return response()->json([
                    'message'       => 'Terdapat kesalahan pada data user, mohon laporkan ke web admin untuk perbaikan',
                    'status'        => 500
                ]);
            }

            $buatkuki = Hash::make(rand());

            $kuki = cookie('tkn', $buatkuki, 3 * 60);       // Cookie expired dalam 3 jam (3 dikali 60 menit) setelah login

            $ModelToken = new SysToken;
            $ModelToken->kd_user    = $ModelUser->username;
            $ModelToken->token      = $buatkuki;
            $ModelToken->save();

            return response()->json([
                'role'      => $ModelUser->role,
                'user'      => $ModelUser->username,
                'nama'      => $ModelUser->fname,
                'status'    => 200
            ])->withCookie($kuki);

        } catch (\Throwable $th) {
            $out = new MetodeBerguna();
            return response()->json($out->outErrCatch($th->getMessage()));
        }
    }

    public function tokenCheck(Request $re)
    {
        try {
            $kuki = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $kuki)->first();

            if(!$ModelToken) {
                return response()->json([
                    'status'        => 404,
                    'message'       => 'User tidak terdaftar'
                ]);
            }

            $ModelUser  = SysUser::where('username',  $ModelToken->kd_user)->first();

            if(!$ModelUser) {
                return response()->json([
                    'status'        => 404,
                    'message'       => 'Token tidak terdaftar'
                ]);
            }

            return response()->json([
                'role'      => $ModelUser->role
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 500,
                'message'   => 'Terjadi kesalahan di server, silahkan hubungi admin website'
            ]);
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
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
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

            $data = new MetodeBerguna;
            return response()->json($data->outputErrorCatch($th->getMessage()));
        }
    }

    public function loginCheck($token)
    {
        try {

            $ModelToken = SysToken::where(['token' => $token])->first();

            if(empty($ModelToken)) {
                $out = new stdClass();
                $out->status = false;

                return $out;
            } else {
                $ModelUser          = SysUser::where('username', $ModelToken->kd_user)->first();
                
                $dibuat             = $ModelToken->created_at;
                $expired            = strtotime($dibuat);
                $exp_datetime       = date('Y-m-d H:i:s', $expired);
                $exp_date           = date('Y-m-d');
                $curr_datetime      = date('Y-m-d H:i:s');
                
                $out                = new stdClass();
                $out->status        = true;
                $out->uname         = $ModelToken->kd_user;
                $out->kd_bank       = $ModelUser->kd_bank;
                $out->timezone      = date_default_timezone_get();
                $out->current       = $curr_datetime;
                $out->exp           = $exp_datetime;

                return $out;
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
