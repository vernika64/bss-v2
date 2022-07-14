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

            $kuki = cookie('tkn', $buatkuki);

            $ModelToken = new SysToken;
            $ModelToken->kd_user    = $ModelUser->username;
            $ModelToken->token      = $buatkuki;
            $ModelToken->save();

            return response()->json([
                'role'      => $ModelUser->role,
                'status'    => 'auth_success'
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
                    'status'      => 'token_error'
                ]);
            }

            $ModelUser  = SysUser::where('username', $ModelToken->kd_user)->first();

            if(!$ModelUser) {
                return response()->json([
                    'status'      => 'token_error'
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
}
