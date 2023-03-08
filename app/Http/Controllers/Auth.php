<?php

namespace App\Http\Controllers;

use App\Models\SysToken;
use App\Models\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function login(Request $re)
    {
        try {

            $ModelUser = SysUser::where('username', $re->username)->first();

            if(!$ModelUser || !Hash::check($re->password, $ModelUser->password))
            {
                return response()->json([
                    'status'    => 'Username atau Password salah'
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
                'nama'      => $ModelUser->fname,
                'status'    => 200
            ])->withCookie($kuki);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }

    public function tokenCheck(Request $re)
    {
        try {
            $kuki = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $kuki)->first();

            if(!$ModelToken) {
                return response()->json([
                    'status'      => 'token_notexist'
                ]);
            }

            $ModelUser  = SysUser::where('username', $ModelToken->kd_user)->first();

            if(!$ModelUser) {
                return response()->json([
                    'status'      => 'user_notlisted'
                ]);
            }

            return response()->json([
                'token'     => $kuki,
                'user'      => $ModelToken->kd_user,
                'role'      => $ModelUser->role
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function checkSudahLogin(Request $re)
    {
        try {
            if($re->cookie('tkn') == null)
            {
                return response()->json(['status' => 'token_notfound']);                // Token tidak ditemukan di komputer client
            } else {
                $ModelToken = SysToken::where('token', $re->cookie('tkn'))->first();

                if(!$ModelToken) {
                    return response()->json(['status' => 'token_notlisted']);           // Token tidak terdaftar di server
                }

                return response()->json(['status' => 'token_available']);               // Token OK
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
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
                    'status'        => 'token_error'
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
}
